<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TaskManagement\Tasks\GetAllTaskManagementsTask;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\FindTaskManagementByIdRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllTaskManagementsAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(FindTaskManagementByIdRequest $request)
    {
        return app(GetAllTaskManagementsTask::class)->run($request->id);
    }
}
