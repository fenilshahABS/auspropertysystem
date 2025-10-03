<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use App\Containers\AppSection\TaskManagement\Tasks\DeleteTaskManagementCustomNotificationTask;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\DeleteTaskManagementRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteTaskManagementCustomNotificationAction extends ParentAction
{

    public function run(DeleteTaskManagementRequest $request)
    {
        return app(DeleteTaskManagementCustomNotificationTask::class)->run($request->id);
    }
}
