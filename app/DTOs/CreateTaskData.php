<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Http\Requests\StoreTaskRequest;

final readonly class CreateTaskData
{
    /**
     * @param  list<string>  $tagIds
     */
    public function __construct(
        public string $title,
        public ?string $description,
        public array $tagIds = [],
    ) {}

    public static function fromRequest(StoreTaskRequest $request): self
    {
        return new self(
            title: $request->string('title')->toString(),
            description: $request->has('description') ? $request->string('description')->toString() : null,
            tagIds: $request->array('tag_ids'),
        );
    }
}
