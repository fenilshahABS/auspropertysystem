<?php

namespace App\Containers\AppSection\Propertytype\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Propertytype\Actions\CreatePropertytypeAction;
use App\Containers\AppSection\Propertytype\Actions\DeletePropertytypeAction;
use App\Containers\AppSection\Propertytype\Actions\FindPropertytypeByIdAction;
use App\Containers\AppSection\Propertytype\Actions\GetAllPropertytypesAction;
use App\Containers\AppSection\Propertytype\Actions\GetAllPropertytypesBySearchAction;
use App\Containers\AppSection\Propertytype\Actions\UpdatePropertytypeAction;
use App\Containers\AppSection\Propertytype\Actions\UpdatePropertytypeByFieldsAction;
use App\Containers\AppSection\Propertytype\Entities\Propertytype;
use App\Containers\AppSection\Propertytype\UI\API\Requests\CreatePropertytypeRequest;
use App\Containers\AppSection\Propertytype\UI\API\Requests\DeletePropertytypeRequest;
use App\Containers\AppSection\Propertytype\UI\API\Requests\FindPropertytypeByIdRequest;
use App\Containers\AppSection\Propertytype\UI\API\Requests\GetAllPropertytypesRequest;
use App\Containers\AppSection\Propertytype\UI\API\Requests\UpdatePropertytypeRequest;
use App\Containers\AppSection\Propertytype\UI\API\Transformers\PropertytypeTransformer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{

    public function createPropertytype(CreatePropertytypeRequest $request)
    {
        $InputData = new Propertytype($request);
        $propertytype = app(CreatePropertytypeAction::class)->run($request, $InputData);

        return $this->transform($propertytype, PropertytypeTransformer::class);
    }

    /**
     * @param FindPropertytypeByIdRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws NotFoundException
     */
    public function findPropertytypeById(FindPropertytypeByIdRequest $request)
    {
        $propertytype = app(FindPropertytypeByIdAction::class)->run($request);

        return $this->transform($propertytype, PropertytypeTransformer::class);
    }


    public function getAllPropertytypes(GetAllPropertytypesRequest $request)
    {
        $propertytypes = app(GetAllPropertytypesAction::class)->run($request);

        return $this->transform($propertytypes, PropertytypeTransformer::class);
    }

    public function getAllPropertytypesBySearch(GetAllPropertytypesRequest $request)
    {
        $InputData = new Propertytype($request);
        $propertytypes = app(GetAllPropertytypesBySearchAction::class)->run($request, $InputData);
        return $propertytypes;
    }


    public function updatePropertytype(UpdatePropertytypeRequest $request): array
    {
        $InputData = new Propertytype($request);
        $propertytype = app(UpdatePropertytypeAction::class)->run($request, $InputData);

        return $this->transform($propertytype, PropertytypeTransformer::class);
    }

    public function updatePropertytypeByFields(UpdatePropertytypeRequest $request)
    {
        $InputData = new Propertytype($request);
        $propertytype = app(UpdatePropertytypeByFieldsAction::class)->run($request, $InputData);
        return $propertytype;
    }

    public function deletePropertytype(DeletePropertytypeRequest $request)
    {
        $propertytype =  app(DeletePropertytypeAction::class)->run($request);
        return $propertytype;
    }
}
