<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('updates the name and timezone of the authenticated user', function (): void {
    $user = User::factory()->create([
        'name' => 'Old Name',
        'timezone' => 'UTC',
    ]);

    $response = $this->actingAs($user)->putJson('/api/profile', [
        'name' => 'New Name',
        'timezone' => 'America/Bogota',
    ]);

    $response->assertOk();
    $response->assertJson([
        'data' => [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => $user->email,
            'timezone' => 'America/Bogota',
        ],
    ]);

    expect($user->fresh())
        ->name->toBe('New Name')
        ->timezone->toBe('America/Bogota');
});

it('returns 401 when the request is unauthenticated', function (): void {
    $response = $this->putJson('/api/profile', [
        'name' => 'New Name',
        'timezone' => 'America/Bogota',
    ]);

    $response->assertUnauthorized();
});

it('returns 422 when name and timezone are missing', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->putJson('/api/profile', []);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['name', 'timezone']);
});

it('returns 422 when the timezone is not a valid timezone identifier', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->putJson('/api/profile', [
        'name' => 'New Name',
        'timezone' => 'Not/A_Timezone',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['timezone']);
});
