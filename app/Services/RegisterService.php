<?php

namespace App\Services;

use App\Models\User;

class RegisterService
{
    public function registerUser($request)
    {
        return User::create($request->validated());
    }
}
