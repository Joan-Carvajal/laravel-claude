<?php

declare(strict_types=1);

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/tasks', [TaskController::class, 'store']);
