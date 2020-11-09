<?php


namespace App\Http\Controllers;


use App\Actions\Task\DestroyAction;
use App\Actions\Task\StoreAction;
use App\Actions\Task\UpdateAction;
use App\Actions\Task\ShowAction;
use App\Actions\Task\ShowAllAction;
use Illuminate\Http\Request;

class TaskController extends ApiController
{
    public function index(Request $request)
    {
        return $this->handleRequest(ShowAllAction::class, $request);
    }

    public function show(Request $request, $id)
    {
        return $this->handleRequest(ShowAction::class, $request, $id);
    }

    public function store(Request $request)
    {
        return $this->handleRequest(StoreAction::class, $request);
    }

    public function update(Request $request, $id)
    {
        return $this->handleRequest(UpdateAction::class, $request, $id);
    }

    public function destroy(Request $request, $id)
    {
        return $this->handleRequest(DestroyAction::class, $request, $id);
    }

}
