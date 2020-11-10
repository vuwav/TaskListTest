<?php


namespace App\Actions\Task;


use App\Models\Task;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class StoreAction extends TaskAction
{

    public function __invoke($request): array
    {
        $this->request = $request;
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
            return $this->workerStoreTask();
        }

        if ($user->checkRole(USER::ROLE_MANAGER)) {
            return $this->managerStoreTask();
        }

        return [['message' => trans('error.unexpected')], 400];
    }

    private function managerStoreTask()
    {
        $workersIds = $this->request->user()
            ->workers()->get('id')
            ->map(fn($worker) => $worker['id']);
        if (!in_array($this->validData['worker_id'], $workersIds->toArray())) {
            return [['message' => trans('error.task.not.your.worker')], 400];
        }

        try {
            $task = Task::create($this->validData);
        } catch (\Exception $e) {
            return [['message' => trans('error.task.when.creating')], 400];
        }
        return [['message' => trans('success.task.created'), 'task' => $task], 200];
    }

    private function workerStoreTask()
    {
        $managerId = $this->request->user()
            ->manager()->get('id')
            ->map(fn($manager) => $manager['id']);
        if (!in_array($this->validData['manager_id'], $managerId->toArray())) {
            return [['message' => trans('error.task.not.your.manager')], 400];
        }

        try {
            $task = Task::create($this->validData);
        } catch (\Exception $e) {
            return [['message' => trans('error.task.when.creating')], 400];
        }
        return [['message' => trans('success.task.created'), 'task' => $task], 200];
    }


}
