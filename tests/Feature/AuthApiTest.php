<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $payload = [
            "name" => "John Doe",
            "email" => "john@example.com",
            "password" => "password",
            "confirm_password" => "password",
        ];

        $response = $this->postJson("/api/v1/register", $payload);

        $response->assertOk();
        $response->assertJsonStructure([
            "user" => ["id", "name", "email"],
            "message",
            "success",
        ]);

        $this->assertDatabaseHas("users", ["email" => "john@example.com"]);
    }

    public function test_user_cannot_register_with_invalid_data()
    {
        $response = $this->postJson("/api/v1/register", []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["name", "email", "password"]);
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            "email" => "test@example.com",
            "password" => "password",
        ]);

        $response = $this->postJson("/api/v1/login", [
            "email" => "test@example.com",
            "password" => "password",
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            "profile" => ["id", "name", "email"],
            "token",
            "success",
        ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            "email" => "test@example.com",
            "password" => bcrypt("correct-password"),
        ]);

        $response = $this->postJson("/api/v1/login", [
            "email" => "test@example.com",
            "password" => "wrong-password",
        ]);

        $response->assertUnauthorized();
        $response->assertJson([
            "message" => "These credentials do not match our records.",
            "success" => false,
        ]);
    }

    public function test_authenticated_user_can_get_their_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, "sanctum")->getJson("/api/v1/me");

        $response->assertOk();
        $response->assertJson([
            "success" => true,
            "profile" => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
            ],
        ]);
    }

    public function test_guest_cannot_access_me_route()
    {
        $response = $this->getJson("/api/v1/me");

        $response->assertUnauthorized();
    }

    public function test_authenticated_user_can_logout()
    {
        $user = User::factory()->create();

        $token = $user->createToken("test-token")->plainTextToken;

        $response = $this->withHeader(
            "Authorization",
            "Bearer " . $token
        )->getJson("/api/v1/logout");

        $response->assertOk();
        $response->assertJson([
            "message" => "logout",
            "success" => true,
        ]);

        $this->assertCount(0, $user->tokens);
    }

    public function test_guest_cannot_access_logout_route()
    {
        $response = $this->getJson("/api/v1/logout");

        $response->assertUnauthorized();
    }
}
