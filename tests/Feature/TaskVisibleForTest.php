<?php

declare(strict_types=1);

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('only returns tasks belonging to the given user', function (): void {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();

    $ownedTasks = Task::factory()->count(2)->for($owner)->create();
    Task::factory()->count(3)->for($otherUser)->create();

    $visibleTasks = Task::query()->visibleFor($owner)->get();

    expect($visibleTasks)->toHaveCount(2)
        ->and($visibleTasks->pluck('id')->sort()->values()->all())
        ->toBe($ownedTasks->pluck('id')->sort()->values()->all());
});
