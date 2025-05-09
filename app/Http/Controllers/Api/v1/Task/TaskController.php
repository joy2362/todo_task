<?php

namespace App\Http\Controllers\Api\v1\Task;

use App\Dto\Api\v1\Task\TaskData;
use App\Enums\Task\TaskStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Task\{CreateTaskRequest, UpdateTaskRequest};
use App\Services\Api\v1\Task\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(public TaskService $service)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/task",
     *     tags={"Task"},
     *     security={{"sanctum": {}}},
     *     summary="Get user task list",
     *     security={{"sanctum": {}}},
     *     description="Get user task",
     *     operationId="getUserTask",
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
    public function index(Request $request)
    {
        $response = $this->service->index($request);
        return response()->json($response['data'], $response['status']);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/task",
     *     tags={"Task"},
     *     security={{"sanctum": {}}},
     *     summary="Create task",
     *     description="User create task",
     *     operationId="createTask",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "body"},
     *             @OA\Property(property="title", type="string", format="title", example="title"),
     *             @OA\Property(property="body", type="string", format="body", example="body")
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
    public function store(CreateTaskRequest $request)
    {
        $validated = $request->validated();
        $dto = new TaskData(
            title: $validated['title'],
            body: $validated['body'],
            status: null
        );
        $response = $this->service->store($dto, $request->user());
        return response()->json($response['data'], $response['status']);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/task/{id}",
     *     tags={"Task"},
     *     security={{"sanctum": {}}},
     *     summary="Get user specific task",
     *     security={{"sanctum": {}}},
     *     operationId="getUserTaskById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task id",
     *         @OA\Schema(type="integer", example=1)
     *     ),
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
    public function show(string $id)
    {
        $response = $this->service->show($id);
        return response()->json($response['data'], $response['status']);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/task/{id}",
     *     tags={"Task"},
     *     security={{"sanctum": {}}},
     *     summary="Update task",
     *     description="User update task",
     *     operationId="updateTask",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task id",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="_method",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", example="PUT")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "body"},
     *             @OA\Property(property="title", type="string", format="title", example="title"),
     *             @OA\Property(property="body", type="string", format="body", example="body"),
     *             @OA\Property(property="status", type="string", format="status", example="completed")
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
    public function update(UpdateTaskRequest $request, string $id)
    {
        $validated = $request->validated();
        $dto = new TaskData(
            title: $validated['title'],
            body: $validated['body'],
            status: $validated['status'] ?? TaskStatusEnum::PENDING->value
        );
        $response = $this->service->update($dto, $id);
        return response()->json($response['data'], $response['status']);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/task/{id}",
     *     tags={"Task"},
     *     security={{"sanctum": {}}},
     *     summary="Delete user task",
     *     security={{"sanctum": {}}},
     *     operationId="deleteUserTask",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task id",
     *         @OA\Schema(type="integer", example=1)
     *     ),
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
    public function destroy(string $id)
    {
        $response = $this->service->destroy($id);
        return response()->json($response['data'], $response['status']);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/task/{id}/mark-as-complete",
     *     tags={"Task"},
     *     security={{"sanctum": {}}},
     *     summary="Mark task as completed",
     *     security={{"sanctum": {}}},
     *     operationId="markAsCompleted",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task id",
     *         @OA\Schema(type="integer", example=1)
     *     ),
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
    public function markAsComplete(string $id)
    {
        $response = $this->service->markAsComplete($id);
        return response()->json($response['data'], $response['status']);
    }
}
