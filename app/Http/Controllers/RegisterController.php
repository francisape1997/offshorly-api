<?php

namespace App\Http\Controllers;

# Services
use App\Services\RegisterService;

# Requests
use App\Http\Requests\RegisterUserRequest;

class RegisterController extends Controller
{
    public function __construct(private readonly RegisterService $registerService) {}

    public function __invoke(RegisterUserRequest $request)
    {
        $response = $this->registerService->registerUser($request);

        return response()->json($response);
    }
}
