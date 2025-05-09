<?php

namespace App\Dto\Api\v1\Task;

class TaskData
{
    public function __construct(
        public string $title,
        public string $body,
        public ?string $status,
    ) {
    }
}
