<?php

namespace App\Containers\AppSection\Permissions\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Permissions\Actions\CreatePermissionsAction;
use App\Containers\AppSection\Permissions\Actions\DeletePermissionsAction;
use App\Containers\AppSection\Permissions\Actions\FindPermissionsByIdAction;
use App\Containers\AppSection\Permissions\Actions\GetAllPermissionsAction;
use App\Containers\AppSection\Permissions\Actions\UpdatePermissionsAction;
use App\Containers\AppSection\Permissions\Entities\Permissions;
use App\Containers\AppSection\Permissions\UI\API\Requests\CreatePermissionsRequest;
use App\Containers\AppSection\Permissions\UI\API\Requests\DeletePermissionsRequest;
use App\Containers\AppSection\Permissions\UI\API\Requests\FindPermissionsByIdRequest;
use App\Containers\AppSection\Permissions\UI\API\Requests\GetAllPermissionsRequest;
use App\Containers\AppSection\Permissions\UI\API\Requests\UpdatePermissionsRequest;
use App\Containers\AppSection\Permissions\UI\API\Transformers\PermissionsTransformer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{

    public function createPermissions(CreatePermissionsRequest $request)
    {
        $permissions = app(CreatePermissionsAction::class)->run($request);

        return $this->created($this->transform($permissions, PermissionsTransformer::class));
    }


    public function findPermissionsById(FindPermissionsByIdRequest $request)
    {
        $permissions = app(FindPermissionsByIdAction::class)->run($request);
        return $permissions;
    }


    public function getAllPermissions(GetAllPermissionsRequest $request)
    {
        $permissions = app(GetAllPermissionsAction::class)->run($request);
        return $permissions;
    }


    public function updatePermissions(UpdatePermissionsRequest $request)
    {
        $InputData = new Permissions($request);
        $permissions = app(UpdatePermissionsAction::class)->run($request, $InputData);
        return $permissions;
    }


    public function deletePermissions(DeletePermissionsRequest $request)
    {
        $permissions = app(DeletePermissionsAction::class)->run($request);
        return $permissions;
    }
}
