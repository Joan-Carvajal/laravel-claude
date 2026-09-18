<?php

declare(strict_types=1);

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a task and assigns tags to it', function (): void {
    $tags = Tag::factory()->count(2)->create();

    $response = $this->postJson('/api/tasks', [
        'title' => 'Ship the tagging feature',
        'description' => 'Attach tags to tasks via the API.',
        'tag_ids' => $tags->pluck('id')->all(),
    ]);

    $response->assertCreated();
    $response->assertJsonCount(2, 'data.tags');
    $response->assertJson([
        'data' => [
            'title' => 'Ship the tagging feature',
            'description' => 'Attach tags to tasks via the API.',
        ],
    ]);

    foreach ($tags as $tag) {
        $response->assertJsonFragment([
            'id' => $tag->id,
            'name' => $tag->name,
            'slug' => $tag->slug,
        ]);
    }

    $task = Task::first();

    expect($task)->not->toBeNull()
        ->and($task->tags)->toHaveCount(2)
        ->and($task->tags->pluck('id')->sort()->values()->all())
        ->toBe($tags->pluck('id')->sort()->values()->all());
});
