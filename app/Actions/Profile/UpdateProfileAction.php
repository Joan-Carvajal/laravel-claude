<?php

declare(strict_types=1);

namespace App\Actions\Profile;

use App\DTOs\UpdateProfileData;
use App\Models\User;

final class UpdateProfileAction
{
    /**
     * Update the given user's name and timezone.
     */
    public function handle(User $user, UpdateProfileData $data): User
    {
        $user->update([
            'name' => $data->name,
            'timezone' => $data->timezone,
        ]);

        return $user;
    }
}
