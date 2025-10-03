<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Containers\AppSection\TaskManagement\Tasks\UpdateTaskManagementTask;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\UpdateTaskManagementRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateTaskManagementAction extends ParentAction
{

    public function run(UpdateTaskManagementRequest $request, $InputData)
    {
        $data = $request->sanitizeInput([
            "task_name" => $InputData->getTaskName(),
            "task_details" => $InputData->getTaskDetails(),
            "task_inspection_date" => $InputData->getTaskInspectionDate(),
            "task_inspection_time" => $InputData->getTaskInspectionTime(),
            "task_datetime" => $InputData->getTaskDateTime(),
            "custom_email" => $InputData->getCustomEmail(),
            "status" => $InputData->getStatus(),
        ]);
        // $data = array_filter($data);
        return app(UpdateTaskManagementTask::class)->run($data, $request->id);
    }
}
