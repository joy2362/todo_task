<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_user_can_create_task()
    {
        $payload = [
            "title" => "Test Task",
            "body" => "Task body content",
            "status" => "pending",
        ];

        $response = $this->actingAs($this->user, "sanctum")->postJson(
            "/api/v1/task",
            $payload
        );

        $response->assertOk();
        $this->assertDatabaseHas("tasks", [
            "title" => "Test Task",
            "user_id" => $this->user->id,
        ]);
    }

    public function test_user_can_get_task_list()
    {
        Task::factory()
            ->count(3)
            ->create(["user_id" => $this->user->id]);

        $response = $this->actingAs($this->user, "sanctum")->getJson(
            "/api/v1/task"
        );

        $response->assertOk();
        $response->assertJsonCount(3, "data");

        $response->assertJsonStructure([
            "data" => [
                "*" => ["id", "title", "body", "status"],
            ],
            "links",
            "meta",
            "success",
        ]);
    }

    public function test_user_can_view_single_task()
    {
        $task = Task::factory()->create(["user_id" => $this->user->id]);

        $response = $this->actingAs($this->user, "sanctum")->getJson(
            "/api/v1/task/{$task->id}"
        );

        $response->assertOk();
        $response->assertJson([
            "data" => [
                "id" => $task->id,
                "title" => $task->title,
                "body" => $task->body,
                "status" => $task->status->value,
            ],
            "success" => true,
        ]);
    }

    public function test_user_can_update_task()
    {
        $task = Task::factory()->create(["user_id" => $this->user->id]);

        $updatedData = [
            "title" => "Updated Title",
            "body" => "Updated body",
            "status" => "completed",
        ];

        $response = $this->actingAs($this->user, "sanctum")->putJson(
            "/api/v1/task/{$task->id}",
            $updatedData
        );

        $response->assertOk();
        $this->assertDatabaseHas("tasks", [
            "id" => $task->id,
            "title" => "Updated Title",
            "status" => "completed",
        ]);
    }

    public function test_user_can_delete_task()
    {
        $task = Task::factory()->create(["user_id" => $this->user->id]);

        $response = $this->actingAs($this->user, "sanctum")->deleteJson(
            "/api/v1/task/{$task->id}"
        );

        $response->assertOk();
        $this->assertDatabaseMissing("tasks", ["id" => $task->id]);
    }

    public function test_guest_cannot_access_task_routes()
    {
        $task = Task::factory()->create();

        $this->getJson("/api/v1/task")->assertUnauthorized();
        $this->postJson("/api/v1/task", [])->assertUnauthorized();
        $this->getJson("/api/v1/task/{$task->id}")->assertUnauthorized();
        $this->putJson("/api/v1/task/{$task->id}", [])->assertUnauthorized();
        $this->deleteJson("/api/v1/task/{$task->id}")->assertUnauthorized();
    }
}
