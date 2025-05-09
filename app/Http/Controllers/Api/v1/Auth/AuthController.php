<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Dto\Api\v1\Auth\{LoginData, RegisterData};
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\{LoginRequest, RegisterRequest};
use App\Http\Resources\Api\v1\Auth\ProfileResource;
use App\Services\Api\v1\Auth\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(public AuthService $service)
    {
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     tags={"Auth"},
     *     summary="Login user",
     *     description="Login user and return JWT token",
     *     operationId="loginUser",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="abdullahzahidjoy@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password"),
     *             @OA\Property(property="remember", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *        @OA\JsonContent(),
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *        @OA\JsonContent(),
     *       response=422,
     *       description="Validation error",
     *     ),
     *      @OA\Response(
     *        @OA\JsonContent(),
     *        response=401,
     *        description="Invalid credentials",
     *     ),
     *     @OA\Response(
     *       @OA\JsonContent(),
     *       response=500,
     *       description="Internal server error",
     *     ),
     * )
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $dto = new LoginData(
            email: $validated['email'],
            password: $validated['password'],
            remember: $validated['remember'] ?? false
        );

        $response = $this->service->login($dto);

        return response()->json($response['data'], $response['status']);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/me",
     *     tags={"Auth"},
     *     summary="Get user profile",
     *     security={{"sanctum": {}}},
     *     description="Get user profile information",
     *     operationId="userProfile",
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *       @OA\JsonContent(),
     *       response=500,
     *       description="Internal server error",
     *     ),
     * )
     */
    public function me(Request $request)
    {
        try {
            $user = $request->user();

            return response()->json([
                'success' => true,
                'profile' => new ProfileResource($user),
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            Log::channel(AuthService::CHANNEL)->error($ex->getMessage());
            return response()->json(['message' => __('message.error')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/logout",
     *     tags={"Auth"},
     *     summary="Logout user",
     *     security={{"sanctum": {}}},
     *     description="Logout user and invalidate token",
     *     operationId="userLogout",
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *       @OA\JsonContent(),
     *       response=500,
     *       description="Internal server error"
     *     ),
     * )
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => __('logout'),
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            Log::channel(AuthService::CHANNEL)->error($ex->getMessage());
            return response()->json(['success' => false, 'message' => __('message.error')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     tags={"Auth"},
     *     summary="Register user to system",
     *     description="Register user to system",
     *     operationId="register",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "name", "password", "confirm_password"},
     *             @OA\Property(property="name", type="string", format="name", example="abdullah zahid"),
     *             @OA\Property(property="email", type="string", format="email", example="abdullahzahidjoy@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678"),
     *             @OA\Property(property="confirm_password", type="string", format="confirm_password", example="12345678"),
     *         )
     *     ),
     *     @OA\Response(
     *        @OA\JsonContent(),
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *        @OA\JsonContent(),
     *       response=422,
     *       description="Validation error",
     *     ),
     *      @OA\Response(
     *        @OA\JsonContent(),
     *        response=401,
     *        description="Invalid credentials",
     *     ),
     *     @OA\Response(
     *       @OA\JsonContent(),
     *       response=500,
     *       description="Internal server error",
     *     ),
     * )
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $dto = new RegisterData(
            name: $validated['name'],
            email: $validated['email'],
            password: $validated['password'],
            confirm_password: $validated['confirm_password'],
        );

        $response = $this->service->register($dto);
        return response()->json($response['data'], $response['status']);
    }
}
