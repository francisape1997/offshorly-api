<?php

namespace App\Http\Controllers;

# Request
use App\Http\Requests\AuthLoginRequest;

# Services
use App\Services\AuthService;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthLoginRequest $request)
    {
        $response = $this->authService->login($request);

        return response()->json($response);
    }

    public function logout()
    {
        $response = $this->authService->logout();

        return response()->json([
            'logout' => $response,
        ]);
    }
}
