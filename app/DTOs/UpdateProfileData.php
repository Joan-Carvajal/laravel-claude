<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Http\Requests\UpdateProfileRequest;

final readonly class UpdateProfileData
{
    public function __construct(
        public string $name,
        public string $timezone,
    ) {}

    public static function fromRequest(UpdateProfileRequest $request): self
    {
        return new self(
            name: $request->string('name')->toString(),
            timezone: $request->string('timezone')->toString(),
        );
    }
}
