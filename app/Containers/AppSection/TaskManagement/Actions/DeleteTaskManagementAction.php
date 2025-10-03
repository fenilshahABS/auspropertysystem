<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use App\Containers\AppSection\TaskManagement\Tasks\DeleteTaskManagementTask;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\DeleteTaskManagementRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteTaskManagementAction extends ParentAction
{
    /**
     * @param DeleteTaskManagementRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteTaskManagementRequest $request): int
    {
        return app(DeleteTaskManagementTask::class)->run($request->id);
    }
}
