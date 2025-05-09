<?php

namespace App\Enums\Task;

use App\Traits\EnumArrayAble;

enum TaskStatusEnum: string
{
    use EnumArrayAble;

    case PENDING = 'pending';
    case COMPLETED = 'completed';
}
