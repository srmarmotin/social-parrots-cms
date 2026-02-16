<?php

use App\Http\Controllers\AvatarController;
use Illuminate\Support\Facades\Route;

Route::get('/avatars', [AvatarController::class, 'active']);
