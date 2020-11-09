<?php


namespace App\Actions\Task;

class ShowAllAction extends TaskAction
{
    public function __invoke($request): array
    {
        return [['tasks' => $request->user()->tasks()->get()], 200];
    }
}
