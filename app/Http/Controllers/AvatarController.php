<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\JsonResponse;

class AvatarController extends Controller
{
    public function active(): JsonResponse
    {
        $avatars = Avatar::where('active', true)->get();

        return response()->json($avatars);
    }
}
