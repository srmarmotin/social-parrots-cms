<?php

namespace App\Http\Controllers;

use App\Http\Resources\AvatarResource;
use App\Models\Avatar;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AvatarController extends Controller
{
    public function active(): AnonymousResourceCollection
    {
        $avatars = Avatar::where('active', true)->get();

        return AvatarResource::collection($avatars);
    }
}
