<?php


namespace App\Http\Controllers;


use App\Actions\User\LoginAction;
use App\Actions\User\RegisterAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController
{
    public function login(Request $request): JsonResponse
    {
        $parameters = app(LoginAction::class)($request);
        Log::info('api.login: ip ' . $request->ip(), $parameters);
        return response()->json(...$parameters);
    }

    public function register(Request $request): JsonResponse
    {
        $parameters = app(RegisterAction::class)($request);
        Log::info('api.register: ip ' . $request->ip(), $parameters);
        return response()->json(...$parameters);
    }
}

