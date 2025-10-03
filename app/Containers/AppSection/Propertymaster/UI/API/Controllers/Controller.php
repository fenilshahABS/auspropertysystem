<?php

namespace App\Containers\AppSection\Propertymaster\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Propertymaster\Actions\CreatePropertymasterAction;
use App\Containers\AppSection\Propertymaster\Actions\DeletePropertymasterAction;
use App\Containers\AppSection\Propertymaster\Actions\DeletePropertyShareDetailsAction;
use App\Containers\AppSection\Propertymaster\Actions\FindPropertymasterByIdAction;
use App\Containers\AppSection\Propertymaster\Actions\GetAllPropertymastersAction;
use App\Containers\AppSection\Propertymaster\Actions\GetOwnerWiseAllPropertymastersAction;
use App\Containers\AppSection\Propertymaster\Actions\GetAllPropertymastersBySearchAction;
use App\Containers\AppSection\Propertymaster\Actions\GetAllPropertymastersByOwnerAction;
use App\Containers\AppSection\Propertymaster\Actions\GetAllPropertymastersApplicationAction;
use App\Containers\AppSection\Propertymaster\Actions\UpdatePropertymasterAction;
use App\Containers\AppSection\Propertymaster\Actions\UpdatePropertymasterByFieldsAction;
use App\Containers\AppSection\Propertymaster\Actions\FindPropertymasterByIdForRentalAction;
use App\Containers\AppSection\Propertymaster\Entities\Propertymaster;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\CreatePropertymasterRequest;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\DeletePropertymasterRequest;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\FindPropertymasterByIdRequest;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\GetAllPropertymastersRequest;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\UpdatePropertymasterRequest;
use App\Containers\AppSection\Propertymaster\UI\API\Transformers\PropertymasterTransformer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{

    public function createPropertymaster(CreatePropertymasterRequest $request)
    {
        $InputData = new Propertymaster($request);
        $propertymaster = app(CreatePropertymasterAction::class)->run($request, $InputData);
        return $this->transform($propertymaster, PropertymasterTransformer::class);
    }

    public function findPropertymasterById(FindPropertymasterByIdRequest $request)
    {
        $propertymaster = app(FindPropertymasterByIdAction::class)->run($request);
        return $propertymaster;
    }
    public function FindPropertymasterByIdForRental(UpdatePropertymasterRequest $request)
    {
        $InputData = new Propertymaster($request);
        $propertymaster = app(FindPropertymasterByIdForRentalAction::class)->run($request, $InputData);
        return $propertymaster;
    }


    public function getOwnerWiseAllPropertymasters(GetAllPropertymastersRequest $request)
    {
        $InputData = new Propertymaster($request);
        $propertymasters = app(GetOwnerWiseAllPropertymastersAction::class)->run($request, $InputData);
        return $propertymasters;
    }

    public function getAllPropertymasters(GetAllPropertymastersRequest $request)
    {
        $propertymasters = app(GetAllPropertymastersAction::class)->run($request);
        return $propertymasters;
    }

    public function getAllPropertymastersBySearch(GetAllPropertymastersRequest $request)
    {
        $InputData = new Propertymaster($request);
        $propertymasters = app(GetAllPropertymastersBySearchAction::class)->run($request, $InputData);
        return $propertymasters;
    }

    public function getAllPropertymastersByOwnerID(GetAllPropertymastersRequest $request)
    {
        $InputData = new Propertymaster($request);
        $propertymasters = app(GetAllPropertymastersByOwnerAction::class)->run($request, $InputData);
        return $propertymasters;
    }

    public function GetAllPropertymastersApplication(GetAllPropertymastersRequest $request)
    {
        $InputData = new Propertymaster($request);
        $propertymasters = app(GetAllPropertymastersApplicationAction::class)->run($request, $InputData);
        return $propertymasters;
    }

    public function updatePropertymaster(UpdatePropertymasterRequest $request)
    {
        $InputData = new Propertymaster($request);
        $propertymaster = app(UpdatePropertymasterAction::class)->run($request, $InputData);
        return $this->transform($propertymaster, PropertymasterTransformer::class);
    }

    public function updatePropertymasterByFields(UpdatePropertymasterRequest $request)
    {
        $InputData = new Propertymaster($request);
        $propertymaster = app(UpdatePropertymasterByFieldsAction::class)->run($request, $InputData);
        // return $this->transform($propertymaster, PropertymasterTransformer::class);
        return $propertymaster;
    }

    public function deletePropertymaster(DeletePropertymasterRequest $request)
    {
        $propertymaster =  app(DeletePropertymasterAction::class)->run($request);
        return $propertymaster;
    }

    public function DeletePropertyShareDetails(DeletePropertymasterRequest $request)
    {

        $propertymaster =  app(DeletePropertyShareDetailsAction::class)->run($request);
        return $propertymaster;
    }
}
