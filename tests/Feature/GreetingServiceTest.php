<?php

declare(strict_types=1);

use App\Services\GreetingService;

it('builds a greeting', function (): void {
    expect((new GreetingService())->greet('Ada'))->toBe('Hola, Ada');
});
