<?php

namespace App\Containers\AppSection\Permissions\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Permissions\Models\Permissions;
use App\Containers\AppSection\Permissions\Tasks\CreatePermissionsTask;
use App\Containers\AppSection\Permissions\UI\API\Requests\CreatePermissionsRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreatePermissionsAction extends ParentAction
{
    /**
     * @param CreatePermissionsRequest $request
     * @return Permissions
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(CreatePermissionsRequest $request): Permissions
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        return app(CreatePermissionsTask::class)->run($data);
    }
}
