<?php

namespace App\Containers\AppSection\Permissions\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Permissions\Models\Permissions;
use App\Containers\AppSection\Permissions\Tasks\UpdatePermissionsTask;
use App\Containers\AppSection\Permissions\UI\API\Requests\UpdatePermissionsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdatePermissionsAction extends ParentAction
{
    use HashIdTrait;
    public function run(UpdatePermissionsRequest $request, $InputData)
    {
        $role_id = $this->decode($InputData->getRoleId());
        $permission_id = $this->decode($InputData->getPermissionId());
        $data = $request->sanitizeInput([
            // "role_id" => $role_id,
            // "permission_id" => $permission_id,
            "status" => $InputData->getStatus()
        ]);
        $data['role_id'] = $role_id;
        $data['permission_id'] = $permission_id;

        return app(UpdatePermissionsTask::class)->run($data, $InputData);
    }
}
