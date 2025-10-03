<?php

namespace App\Containers\AppSection\Rolemaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Rolemaster\Tasks\GetAllRolemastersTask;
use App\Containers\AppSection\Rolemaster\UI\API\Requests\GetAllRolemastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRolemastersAction extends ParentAction
{
    public function run(GetAllRolemastersRequest $request)
    {
        return app(GetAllRolemastersTask::class)->run();
    }
}
