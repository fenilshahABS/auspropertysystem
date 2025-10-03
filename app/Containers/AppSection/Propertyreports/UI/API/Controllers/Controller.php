<?php

namespace App\Containers\AppSection\Propertyreports\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Propertyreports\Actions\CreatePropertyreportsAction;
use App\Containers\AppSection\Propertyreports\Actions\DeletePropertyreportsAction;
use App\Containers\AppSection\Propertyreports\Actions\FindPropertyreportsByIdAction;
use App\Containers\AppSection\Propertyreports\Actions\GetAllPropertyreportsAction;
use App\Containers\AppSection\Propertyreports\Actions\UpdatePropertyreportsAction;
use App\Containers\AppSection\Propertyreports\Entities\Propertyreports;
use App\Containers\AppSection\Propertyreports\UI\API\Requests\CreatePropertyreportsRequest;
use App\Containers\AppSection\Propertyreports\UI\API\Requests\DeletePropertyreportsRequest;
use App\Containers\AppSection\Propertyreports\UI\API\Requests\FindPropertyreportsByIdRequest;
use App\Containers\AppSection\Propertyreports\UI\API\Requests\GetAllPropertyreportsRequest;
use App\Containers\AppSection\Propertyreports\UI\API\Requests\UpdatePropertyreportsRequest;
use App\Containers\AppSection\Propertyreports\UI\API\Transformers\PropertyreportsTransformer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    /**
     * @param CreatePropertyreportsRequest $request
     * @return JsonResponse
     * @throws InvalidTransformerException
     * @throws CreateResourceFailedException
     */
    public function createPropertyreports(CreatePropertyreportsRequest $request): JsonResponse
    {
        $propertyreports = app(CreatePropertyreportsAction::class)->run($request);

        return $this->created($this->transform($propertyreports, PropertyreportsTransformer::class));
    }

    /**
     * @param FindPropertyreportsByIdRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws NotFoundException
     */
    public function findPropertyreportsById(FindPropertyreportsByIdRequest $request): array
    {
        $propertyreports = app(FindPropertyreportsByIdAction::class)->run($request);

        return $this->transform($propertyreports, PropertyreportsTransformer::class);
    }

    /**
     * @param GetAllPropertyreportsRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function getAllPropertyreports(GetAllPropertyreportsRequest $request)
    {
        $InputData = new Propertyreports($request);
        $propertyreports = app(GetAllPropertyreportsAction::class)->run($request, $InputData);
        return $propertyreports;
    }



    /**
     * @param UpdatePropertyreportsRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws UpdateResourceFailedException
     */
    public function updatePropertyreports(UpdatePropertyreportsRequest $request): array
    {
        $propertyreports = app(UpdatePropertyreportsAction::class)->run($request);

        return $this->transform($propertyreports, PropertyreportsTransformer::class);
    }

    /**
     * @param DeletePropertyreportsRequest $request
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function deletePropertyreports(DeletePropertyreportsRequest $request): JsonResponse
    {
        app(DeletePropertyreportsAction::class)->run($request);

        return $this->noContent();
    }
}
