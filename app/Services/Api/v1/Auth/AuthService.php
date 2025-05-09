<?php

namespace App\Services\Api\v1\Auth;

use App\Dto\Api\v1\Auth\{LoginData, RegisterData};
use App\Http\Resources\Api\v1\Auth\ProfileResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\{Hash, Log};
use Symfony\Component\HttpFoundation\Response;

class AuthService
{
    public const CHANNEL = "auth";

    /**
     * @param  LoginData  $data
     * @return array<string, mixed>
     */
    public function login(LoginData $data): array
    {
        try {
            $user = User::query()->whereEmail($data->email)->first();

            if (!$user || !Hash::check($data->password, $user->password)) {
                return errorResponse(
                    __("auth.failed"),
                    Response::HTTP_UNAUTHORIZED
                );
            }

            return successResponse($this->loginData($user));
        } catch (Exception $ex) {
            Log::channel(self::CHANNEL)->error($ex->getMessage());
            return errorResponse(__("error"));
        }
    }

    public function register(RegisterData $data)
    {
        try {
            $user = User::query()->create([
                "name" => $data->name,
                "email" => $data->email,
                "password" => $data->password,
            ]);

            return successResponse([
                "user" => $user,
                "message" => "User register successfully!",
            ]);
        } catch (Exception $ex) {
            Log::channel(self::CHANNEL)->error($ex->getMessage());
            return errorResponse(__("error"));
        }
    }

    /*
    |
    |--------------------------------------------------------------------------
    | class internal methods
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @param $email
     * @param null $remember
     * @param null $message
     * @return array
     */
    private function loginData(User $user): array
    {
        return [
            "profile" => new ProfileResource($user),
            "token" => $this->generateAuthToken($user),
        ];
    }

    /**
     * @param User $user
     * @return mixed
     */
    private function generateAuthToken(User $user): mixed
    {
        return $user->createToken("token")->plainTextToken;
    }
}
