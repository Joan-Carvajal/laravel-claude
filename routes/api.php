<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/tasks', [TaskController::class, 'store']);

Route::middleware('auth')->put('/profile', [ProfileController::class, 'update']);
