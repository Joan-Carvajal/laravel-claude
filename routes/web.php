<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::get('/ping', fn () => response()->json(['status' => 'ok']));
