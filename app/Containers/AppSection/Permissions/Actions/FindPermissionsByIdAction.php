<?php

namespace App\Containers\AppSection\Permissions\Actions;

use App\Containers\AppSection\Permissions\Models\Permissions;
use App\Containers\AppSection\Permissions\Tasks\FindPermissionsByIdTask;
use App\Containers\AppSection\Permissions\UI\API\Requests\FindPermissionsByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindPermissionsByIdAction extends ParentAction
{

    public function run(FindPermissionsByIdRequest $request)
    {
        return app(FindPermissionsByIdTask::class)->run($request->id);
    }
}
