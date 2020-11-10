<?php


namespace App\Actions\Task;

use Illuminate\Validation\ValidationException;

class ShowAction extends TaskAction
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

        if (!$task = $request->user()->task($id)->first()) {
            return [['message' => trans('error.task.you.dont.have')], 401];
        }
        return [['task' => $task], 200];
    }
}
