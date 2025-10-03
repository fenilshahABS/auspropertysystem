<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Containers\AppSection\TaskManagement\Tasks\CreateTaskManagementTask;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\CreateTaskManagementRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateTaskManagementAction extends ParentAction
{
    use HashIdTrait;
    public function run(CreateTaskManagementRequest $request, $InputData)
    {
        $user_id = $this->decode($InputData->getUserid());
        $data = $request->sanitizeInput([
            "task_name" => $InputData->getTaskName(),
            "task_details" => $InputData->getTaskDetails(),
            "task_inspection_date" => $InputData->getTaskInspectionDate(),
            "task_inspection_time" => $InputData->getTaskInspectionTime(),
            "custom_email" => $InputData->getCustomEmail(),
            "task_datetime" => $InputData->getTaskDateTime(),
            "status" => 0,
        ]);
        $data['user_id'] = $user_id;

        return app(CreateTaskManagementTask::class)->run($data);
    }
}
