<?php

namespace App\Containers\AppSection\Rolemaster\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Rolemaster\Actions\CreateRolemasterAction;
use App\Containers\AppSection\Rolemaster\Actions\DeleteRolemasterAction;
use App\Containers\AppSection\Rolemaster\Actions\FindRolemasterByIdAction;
use App\Containers\AppSection\Rolemaster\Actions\GetAllRolemastersAction;
use App\Containers\AppSection\Rolemaster\Actions\GetAllRolemastersWithoutAdminAction;
use App\Containers\AppSection\Rolemaster\Actions\UpdateRolemasterAction;
use App\Containers\AppSection\Rolemaster\Actions\UpdateRolemasterstatusAction;
use App\Containers\AppSection\Rolemaster\UI\API\Requests\CreateRolemasterRequest;
use App\Containers\AppSection\Rolemaster\UI\API\Requests\DeleteRolemasterRequest;
use App\Containers\AppSection\Rolemaster\UI\API\Requests\FindRolemasterByIdRequest;
use App\Containers\AppSection\Rolemaster\UI\API\Requests\GetAllRolemastersRequest;
use App\Containers\AppSection\Rolemaster\UI\API\Requests\UpdateRolemasterRequest;
use App\Containers\AppSection\Rolemaster\UI\API\Transformers\RolemasterTransformer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createRolemaster(CreateRolemasterRequest $request)
    {
        $rolemaster = app(CreateRolemasterAction::class)->run($request);
        return $rolemaster;
    }

    public function findRolemasterById(FindRolemasterByIdRequest $request)
    {
        $rolemaster = app(FindRolemasterByIdAction::class)->run($request);
        return $rolemaster;
    }

    public function getAllRolemasters(GetAllRolemastersRequest $request)
    {
        $rolemasters = app(GetAllRolemastersAction::class)->run($request);
        return $rolemasters;
    }

    public function getAllRolemastersWithoutAdmin(GetAllRolemastersRequest $request)
    {
        $rolemasters = app(GetAllRolemastersWithoutAdminAction::class)->run($request);
        return $rolemasters;
    }

    public function updateRolemaster(UpdateRolemasterRequest $request)
    {
        $rolemaster = app(UpdateRolemasterAction::class)->run($request);
        return $rolemaster;
    }

  

    public function deleteRolemaster(DeleteRolemasterRequest $request)
    {
        $rolemaster = app(DeleteRolemasterAction::class)->run($request);
        return $rolemaster;
    }
}
