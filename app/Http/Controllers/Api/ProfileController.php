<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request): ProfileResource
    {
        /** @var User $authUser */
        $authUser = $request->user();

        return ProfileResource::make($authUser);
    }

//    TODO: Add update and destroy functions
}
