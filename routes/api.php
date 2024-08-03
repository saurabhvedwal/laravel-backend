<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\UserController;

Route::middleware(['auth:sanctum'])->get('/v1/user', [UserController::class, 'getUser']);
