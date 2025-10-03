<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Containers\AppSection\TaskManagement\Tasks\FindTaskManagementByIdTask;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\FindTaskManagementByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindTaskManagementByIdAction extends ParentAction
{
    /**
     * @throws NotFoundException
     */
    public function run(FindTaskManagementByIdRequest $request): TaskManagement
    {
        return app(FindTaskManagementByIdTask::class)->run($request->id);
    }
}
