<?php

namespace App\Models;

use App\Enums\Task\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return ['status' => TaskStatusEnum::class];
    }

    protected $fillable = [
        'title',
        'body',
        'status',
        'user_id',
    ];

}
