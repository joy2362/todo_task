<?php

namespace App\Http\Requests\Api\v1\Task;

use App\Enums\Task\TaskStatusEnum;
use App\Http\Requests\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !!$this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'body' => ['required', 'string', 'min:1', 'max:1000'],
            'status' => ['nullable', 'string', Rule::enum(TaskStatusEnum::class)],
        ];
    }
}
