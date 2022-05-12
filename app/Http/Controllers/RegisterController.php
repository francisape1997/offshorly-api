<?php

namespace App\Http\Controllers;

# Services
use App\Services\RegisterService;

# Requests
use App\Http\Requests\RegisterUserRequest;

class RegisterController extends Controller
{
    private $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function __invoke(RegisterUserRequest $request)
    {
        $response = $this->registerService->registerUser($request);

        return response()->json($response);
    }
}
