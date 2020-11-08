<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    protected function handleRequest($actionName, Request $request, $id = null)
    {
        $parameters = app($actionName)($request, $id);
        Log::info("api.{$actionName}: ip " . $request->ip(), $parameters);
        return response()->json(...$parameters);
    }
}
