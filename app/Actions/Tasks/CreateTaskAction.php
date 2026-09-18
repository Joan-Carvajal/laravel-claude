<?php

declare(strict_types=1);

namespace App\Actions\Tasks;

use App\DTOs\CreateTaskData;
use App\Models\Task;

final class CreateTaskAction
{
    /**
     * Create a task and attach the given tags to it.
     */
    public function handle(CreateTaskData $data): Task
    {
        $task = Task::create([
            'title' => $data->title,
            'description' => $data->description,
        ]);

        if ($data->tagIds !== []) {
            $task->tags()->sync($data->tagIds);
        }

        return $task->load('tags');
    }
}
