<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Profile\UpdateProfileAction;
use App\DTOs\UpdateProfileData;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * Update the authenticated user's name and timezone.
     */
    public function update(UpdateProfileRequest $request, UpdateProfileAction $action): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $user = $action->handle($user, UpdateProfileData::fromRequest($request));

        return UserResource::make($user)->response();
    }
}
