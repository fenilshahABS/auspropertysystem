<?php

namespace App\Containers\AppSection\Permissions\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Permissions\Tasks\GetAllPermissionsTask;
use App\Containers\AppSection\Permissions\UI\API\Requests\GetAllPermissionsRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllPermissionsAction extends ParentAction
{

    public function run(GetAllPermissionsRequest $request)
    {
        return app(GetAllPermissionsTask::class)->run();
    }
}
