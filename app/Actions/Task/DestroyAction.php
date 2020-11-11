<?php


namespace App\Actions\Task;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class DestroyAction extends TaskAction
{
    public function __invoke($request, $id): array
    {
        $validator = validator(
            ['id' => $id], $this->getRules(self::class)
        );

        try {
            $validator->validated();
        } catch (ValidationException $e) {
            return [['message' => $validator->errors()], 400];
        }

        $user = $request->user();
        $task = $request->user()->task($id)->first();

        if (
            $user->role === User::ROLE_WORKER &&
            $task->creator_id !== $user->id
        ) {
            return [['message' => trans('error.task.you.cant.delete')], 400];
        }

        if (!$task->delete()) {
            return [['message' => trans('error.task.you.dont.have')], 400];
        }

        return [['message' => trans('success.task.deleted'), 'task' => $task], 200];
    }
}
