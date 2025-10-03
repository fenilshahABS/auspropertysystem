<?php

namespace App\Containers\AppSection\Workermaster\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Workermaster\Actions\CreateWorkermasterAction;
use App\Containers\AppSection\Workermaster\Actions\DeleteWorkermasterAction;
use App\Containers\AppSection\Workermaster\Actions\FindWorkermasterByIdAction;
use App\Containers\AppSection\Workermaster\Actions\GetAllWorkermastersAction;
use App\Containers\AppSection\Workermaster\Actions\GetAllWorkermastersBySearchAction;
use App\Containers\AppSection\Workermaster\Actions\UpdateWorkermasterAction;
use App\Containers\AppSection\Workermaster\Actions\UpdateWorkermasterByFieldsAction;
use App\Containers\AppSection\Workermaster\UI\API\Requests\CreateWorkermasterRequest;
use App\Containers\AppSection\Workermaster\UI\API\Requests\DeleteWorkermasterRequest;
use App\Containers\AppSection\Workermaster\UI\API\Requests\FindWorkermasterByIdRequest;
use App\Containers\AppSection\Workermaster\UI\API\Requests\GetAllWorkermastersRequest;
use App\Containers\AppSection\Workermaster\UI\API\Requests\UpdateWorkermasterRequest;
use App\Containers\AppSection\Workermaster\UI\API\Transformers\WorkermasterTransformer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\AppSection\Workermaster\Entities\Workermaster;

class Controller extends ApiController
{
    /**
     * @param CreateWorkermasterRequest $request
     * @return JsonResponse
     * @throws InvalidTransformerException
     * @throws CreateResourceFailedException
     */
    public function createWorkermaster(CreateWorkermasterRequest $request)
    {
        $InputData = new Workermaster($request);
        $workermaster = app(CreateWorkermasterAction::class)->run($request, $InputData);

        return $this->transform($workermaster, WorkermasterTransformer::class);
    }

    /**
     * @param FindWorkermasterByIdRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws NotFoundException
     */
    public function findWorkermasterById(FindWorkermasterByIdRequest $request)
    {
        $workermaster = app(FindWorkermasterByIdAction::class)->run($request);

        return $this->transform($workermaster, WorkermasterTransformer::class);
    }

    /**
     * @param GetAllWorkermastersRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function getAllWorkermasters(GetAllWorkermastersRequest $request)
    {
        $workermasters = app(GetAllWorkermastersAction::class)->run($request);

        return $this->transform($workermasters, WorkermasterTransformer::class);
    }

    public function getAllWorkermastersBySearch(GetAllWorkermastersRequest $request)
    {
        $InputData = new Workermaster($request);
        $Workermaster = app(GetAllWorkermastersBySearchAction::class)->run($request, $InputData);
        return $Workermaster;
    }

    /**
     * @param UpdateWorkermasterRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws UpdateResourceFailedException
     */
    public function updateWorkermaster(UpdateWorkermasterRequest $request)
    {
      $InputData = new Workermaster($request);
        $workermaster = app(UpdateWorkermasterAction::class)->run($request, $InputData);

        return $this->transform($workermaster, WorkermasterTransformer::class);
    }

    public function updateWorkermasterByFields(UpdateWorkermasterRequest $request)
    {
        $InputData = new Workermaster($request);
        $Workermaster = app(UpdateWorkermasterByFieldsAction::class)->run($request, $InputData);
        return $Workermaster;
    }

    /**
     * @param DeleteWorkermasterRequest $request
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function deleteWorkermaster(DeleteWorkermasterRequest $request)
    {
        $propertytype =  app(DeleteWorkermasterAction::class)->run($request);
        return $propertytype;
    }
}
