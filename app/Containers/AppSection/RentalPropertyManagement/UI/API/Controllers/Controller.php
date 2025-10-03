<?php

namespace App\Containers\AppSection\RentalPropertyManagement\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\RentalPropertyManagement\Actions\CreateRentalPropertyManagementAction;
use App\Containers\AppSection\RentalPropertyManagement\Actions\DeleteRentalPropertyManagementAction;
use App\Containers\AppSection\RentalPropertyManagement\Actions\FindRentalPropertyManagementByIdAction;
use App\Containers\AppSection\RentalPropertyManagement\Actions\GetAllRentalPropertyManagementsAction;
use App\Containers\AppSection\RentalPropertyManagement\Actions\GetAllRentalPropertyManagementsBySearchAction;
use App\Containers\AppSection\RentalPropertyManagement\Actions\UpdateRentalPropertyManagementAction;
use App\Containers\AppSection\RentalPropertyManagement\Actions\UpdateRentalPropertyManagementByFieldsAction;
use App\Containers\AppSection\RentalPropertyManagement\Entities\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagement\UI\API\Requests\CreateRentalPropertyManagementRequest;
use App\Containers\AppSection\RentalPropertyManagement\UI\API\Requests\DeleteRentalPropertyManagementRequest;
use App\Containers\AppSection\RentalPropertyManagement\UI\API\Requests\FindRentalPropertyManagementByIdRequest;
use App\Containers\AppSection\RentalPropertyManagement\UI\API\Requests\GetAllRentalPropertyManagementsRequest;
use App\Containers\AppSection\RentalPropertyManagement\UI\API\Requests\UpdateRentalPropertyManagementRequest;
use App\Containers\AppSection\RentalPropertyManagement\UI\API\Transformers\RentalPropertyManagementTransformer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{

    public function createRentalPropertyManagement(CreateRentalPropertyManagementRequest $request)
    {
        $InputData = new RentalPropertyManagement($request);
        $rentalpropertymanagement = app(CreateRentalPropertyManagementAction::class)->run($request, $InputData);

        return $this->transform($rentalpropertymanagement, RentalPropertyManagementTransformer::class);
    }


    public function findRentalPropertyManagementById(FindRentalPropertyManagementByIdRequest $request): array
    {
        $rentalpropertymanagement = app(FindRentalPropertyManagementByIdAction::class)->run($request);

        return $this->transform($rentalpropertymanagement, RentalPropertyManagementTransformer::class);
    }

    /**
     * @param GetAllRentalPropertyManagementsRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */

    public function getAllRentalPropertyManagements(GetAllRentalPropertyManagementsRequest $request): array
    {
        $rentalpropertymanagements = app(GetAllRentalPropertyManagementsAction::class)->run($request);

        return $rentalpropertymanagements;
    }
    public function GetAllRentalPropertyManagementsBySearch(GetAllRentalPropertyManagementsRequest $request)
    {
        $InputData = new RentalPropertyManagement($request);
        $rentalpropertymanagements = app(GetAllRentalPropertyManagementsBySearchAction::class)->run($request, $InputData);
        return $rentalpropertymanagements;
    }


    public function updateRentalPropertyManagement(UpdateRentalPropertyManagementRequest $request): array
    {
        $InputData = new RentalPropertyManagement($request);
        $rentalpropertymanagement = app(UpdateRentalPropertyManagementAction::class)->run($request, $InputData);

        return $this->transform($rentalpropertymanagement, RentalPropertyManagementTransformer::class);
    }


    public function UpdateRentalPropertyManagementByFields(UpdateRentalPropertyManagementRequest $request)
    {
        $InputData = new RentalPropertyManagement($request);
        $rentalpropertymanagement = app(UpdateRentalPropertyManagementByFieldsAction::class)->run($request, $InputData);
        return $rentalpropertymanagement;
    }

    public function deleteRentalPropertyManagement(DeleteRentalPropertyManagementRequest $request)
    {
        $rentalpropertymanagement = app(DeleteRentalPropertyManagementAction::class)->run($request);
        return $rentalpropertymanagement;
    }
}
