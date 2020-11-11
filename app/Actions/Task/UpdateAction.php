<?php


namespace App\Actions\Task;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class UpdateAction extends TaskAction
{
    public function __invoke($request, $id): array
    {
        $this->request = $request;
        $this->id = $id;
        $validator = validator(
            $request->all(),
            $this->getRules(self::class)
        );

        try {
            $this->validData = $validator->validate();
        } catch (ValidationException $e) {
            return [['message' => $validator->errors()], 400];
        }

        $user = $this->request->user();
        if ($user->checkRole(User::ROLE_WORKER)) {
            return $this->workerUpdateTask();
        }

        if ($user->checkRole(USER::ROLE_MANAGER)) {
            return $this->managerUpdateTask();
        }

        return [['message' => trans('error.unexpected')], 400];
    }

    private function managerUpdateTask()
    {
        $workersIds = $this->request->user()
            ->workers()->get('id')
            ->map(fn($worker) => $worker['id']);
        if (!in_array($this->validData['worker_id'], $workersIds->toArray())) {
            return [['message' => trans('error.task.not.your.worker')], 400];
        }

        try {
            $this->request->user()->task($this->id)->update($this->validData);
        } catch (\Exception $e) {
            return [['message' => trans('error.task.when.creating')], 400];
        }
        return [['message' => trans('success.task.updated')], 200];
    }

    private function workerUpdateTask()
    {
        $user = $this->request->user();
        $task = $this->request->user()->task($this->id)->first();

        $managerId = $user->manager()->get('id')
            ->map(fn($manager) => $manager['id']);
        if (!in_array($this->validData['manager_id'], $managerId->toArray())) {
            return [['message' => trans('error.task.not.your.manager')], 400];
        }

        if (
            $task->creator_id !== $user->id
        ) {
            $this->validData = ['status' => $this->validData['status']];
        }

        try {
            $this->request->user()->task($this->id)->update($this->validData);
        } catch (\Exception $e) {
            return [['message' => trans('error.task.when.creating')], 400];
        }
        return [['message' => trans('success.task.updated')], 200];
    }
}
