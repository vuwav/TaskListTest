<?php


namespace App\Http\Controllers;

use App\Actions\User\ShowAction;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function me(Request $request)
    {
        return $this->handleRequest(ShowAction::class, $request);
    }
}
