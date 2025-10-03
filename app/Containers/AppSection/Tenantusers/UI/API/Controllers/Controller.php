<?php

namespace App\Containers\AppSection\Tenantusers\UI\API\Controllers;

use App\Containers\AppSection\Tenantusers\UI\API\Requests\CreateTenantusersRequest;
use App\Containers\AppSection\Tenantusers\UI\API\Requests\DeleteTenantusersRequest;
use App\Containers\AppSection\Tenantusers\UI\API\Requests\GetAllTenantusersRequest;
use App\Containers\AppSection\Tenantusers\UI\API\Requests\FindTenantusersByIdRequest;
use App\Containers\AppSection\Tenantusers\UI\API\Requests\UpdateTenantusersRequest;
use App\Containers\AppSection\Tenantusers\Actions\CreateTenantusersAction;
use App\Containers\AppSection\Tenantusers\Actions\DeleteTenantusersAction;
use App\Containers\AppSection\Tenantusers\Actions\FindTenantusersByIdAction;
use App\Containers\AppSection\Tenantusers\Actions\FindTenantusersByUiquenumberAction;
use App\Containers\AppSection\Tenantusers\Actions\GetAllTenantusersAction;
use App\Containers\AppSection\Tenantusers\Actions\GetAllTenantuserBySearchAction;
use App\Containers\AppSection\Tenantusers\Actions\ResetTenantusersPasswordAction;
use App\Containers\AppSection\Tenantusers\Actions\TestEmailAction;
use App\Containers\AppSection\Tenantusers\Actions\UpdateTenantusersAction;
use App\Containers\AppSection\Tenantusers\Actions\UpdateTenantusersByFieldAction;
use App\Containers\AppSection\Tenantusers\Actions\UpdateTenantusersPasswordAction;
use App\Containers\AppSection\Tenantusers\Entities\Tenantusers;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function createTenantusers(CreateTenantusersRequest $request)
    {
        $InputData = new Tenantusers(
            $request
        );
        $tenantusers = app(CreateTenantusersAction::class)->run($request, $InputData);
        return $tenantusers;
    }

    public function findTenantusersById(FindTenantusersByIdRequest $request)
    {
        $tenantusers = app(FindTenantusersByIdAction::class)->run($request);
        return $tenantusers;
    }

    public function getAllTenantusers(GetAllTenantusersRequest $request)
    {
        $InputData = new Tenantusers(
            $request
        );
        $tenantusers = app(GetAllTenantusersAction::class)->run($request, $InputData);
        return $tenantusers;
    }

    public function GetAllTenantuserBySearch(GetAllTenantusersRequest $request)
    {
        $InputData = new Tenantusers(
            $request
        );

        $tenantusers = app(GetAllTenantuserBySearchAction::class)->run($request, $InputData);
        return $tenantusers;
    }

    public function updateTenantusers(UpdateTenantusersRequest $request)
    {
        $InputData = new Tenantusers(
            $request
        );
        $tenantusers = app(UpdateTenantusersAction::class)->run($request, $InputData);
        return $tenantusers;
    }

    public function updateTenantusersByField(UpdateTenantusersRequest $request)
    {
        $InputData = new Tenantusers($request);
        $tenantusers = app(UpdateTenantusersByFieldAction::class)->run($request, $InputData);
        return $tenantusers;
    }

    public function deleteTenantusers(DeleteTenantusersRequest $request)
    {
        $tenantusers = app(DeleteTenantusersAction::class)->run($request);
        return $tenantusers;
    }

    public function testEmail(GetAllTenantusersRequest $request)
    {
        $returnData = app(TestEmailAction::class)->run($request);
        return $returnData;
    }

    public function updateTenantusersPassword(GetAllTenantusersRequest $request)
    {
        $InputData = new Tenantusers(
            $request
        );
        $returnData = app(UpdateTenantusersPasswordAction::class)->run($request, $InputData);
        return $returnData;
    }
    public function resetTenantusersPassword(CreateTenantusersRequest $request)
    {
        $InputData = new Tenantusers($request);
        $returnData = app(ResetTenantusersPasswordAction::class)->run($request, $InputData);
        return $returnData;
    }
}
