<?php


namespace App\Actions\Task;

use Laravel\Lumen\Http\Request;

class TaskAction
{
    protected Request $request;
    protected array $validData;
    protected int $id;

    protected function getRules($action)
    {
        $showDestroy = ['id' => 'numeric'];
        $storeUpdate = [
            'title' => 'required',
            'description' => 'required',
            'priority' => 'required|between:0,2',
            'status' => 'required|between:0,3',
            'manager_id' => 'required|numeric',
            'worker_id' => 'required|numeric',
            'done_at' => 'date'
        ];
        $rules = [
            ShowAction::class => $showDestroy,
            DestroyAction::class => $showDestroy,
            StoreAction::class => $storeUpdate,
            UpdateAction::class => $storeUpdate,
        ];
        return $rules[$action];
    }
}
