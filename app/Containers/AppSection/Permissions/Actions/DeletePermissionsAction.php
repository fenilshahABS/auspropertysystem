<?php

namespace App\Containers\AppSection\Permissions\Actions;

use App\Containers\AppSection\Permissions\Tasks\DeletePermissionsTask;
use App\Containers\AppSection\Permissions\UI\API\Requests\DeletePermissionsRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeletePermissionsAction extends ParentAction
{
    /**
     * @param DeletePermissionsRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeletePermissionsRequest $request): int
    {
        return app(DeletePermissionsTask::class)->run($request->id);
    }
}
