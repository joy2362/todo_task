<?php

namespace App\Services\Api\v1\Task;

use App\Dto\Api\v1\Task\TaskData;
use App\Enums\Task\TaskStatusEnum;
use App\Http\Resources\Api\v1\Task\TaskResource;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskService
{
    public const CHANNEL = "task";

    public function index(Request $request)
    {
        try {
            $task = $request
                ->user()
                ->task()
                ->paginate($request->per_page ?? 10)
                ->withQueryString();

            return successResponse(
                TaskResource::collection($task)->response()->getData(true)
            );
        } catch (Exception $ex) {
            Log::channel(self::CHANNEL)->error($ex->getMessage());
            return errorResponse(__("error"));
        }
    }

    public function store(TaskData $data, User $user)
    {
        try {
            $task = $user->task()->create([
                "title" => $data->title,
                "body" => $data->body,
            ]);
            return successResponse([
                "data" => $task,
                "message" => "Resource created successfully",
            ]);
        } catch (Exception $ex) {
            Log::channel(self::CHANNEL)->error($ex->getMessage());
            return errorResponse(__("error"));
        }
    }

    public function show(string $id)
    {
        try {
            $task = Task::findOrFail($id);
            return successResponse(
                new TaskResource($task)->response()->getData(true)
            );
        } catch (Exception $ex) {
            Log::channel(self::CHANNEL)->error($ex->getMessage());
            return errorResponse(__("error"));
        }
    }

    public function update(TaskData $data, string $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->update([
                "title" => $data->title,
                "body" => $data->body,
                "status" => $data->status,
            ]);
            return successResponse([
                "data" => $task,
                "message" => "Resource updated successfully",
            ]);
        } catch (Exception $ex) {
            Log::channel(self::CHANNEL)->error($ex->getMessage());
            return errorResponse(__("error"));
        }
    }

    public function destroy(string $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return successResponse([
                "message" => "Resource deleted successfully",
            ]);
        } catch (Exception $ex) {
            Log::channel(self::CHANNEL)->error($ex->getMessage());
            return errorResponse(__("error"));
        }
    }

    public function markAsComplete(string $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->update([
                "status" => TaskStatusEnum::COMPLETED->value,
            ]);
            return successResponse([
                "date" => $task,
                "message" => "Resource updated successfully",
            ]);
        } catch (Exception $ex) {
            Log::channel(self::CHANNEL)->error($ex->getMessage());
            return errorResponse(__("error"));
        }
    }
}
