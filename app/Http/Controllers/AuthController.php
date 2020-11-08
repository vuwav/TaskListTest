<?php


namespace App\Http\Controllers;


use App\Actions\User\LoginAction;
use App\Actions\User\RegisterAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function login(Request $request): JsonResponse
    {
        return $this->handleRequest(LoginAction::class, $request);
    }

    public function register(Request $request): JsonResponse
    {
        return $this->handleRequest(RegisterAction::class, $request);
    }
}

