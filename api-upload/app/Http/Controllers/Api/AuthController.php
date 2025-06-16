<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Services\Api\AuthService;
use App\Http\Requests\AuthRequest;


class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(AuthRequest $request)
    {
        return $this->authService->register($request);
    }
}
