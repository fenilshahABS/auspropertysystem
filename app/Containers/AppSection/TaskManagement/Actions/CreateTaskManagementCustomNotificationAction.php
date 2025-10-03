<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Containers\AppSection\TaskManagement\Tasks\CreateTaskManagementCustomNotificationTask;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\CreateTaskManagementRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateTaskManagementCustomNotificationAction extends ParentAction
{
    use HashIdTrait;
    public function run(CreateTaskManagementRequest $request, $InputData)
    {

        $data = $request->sanitizeInput([

            "task_datetime" => $InputData->getTaskDateTime(),
        ]);
        $data['task_management_id'] = $this->decode($InputData->getTaskManagementId());

        return app(CreateTaskManagementCustomNotificationTask::class)->run($data, $InputData);
    }
}
