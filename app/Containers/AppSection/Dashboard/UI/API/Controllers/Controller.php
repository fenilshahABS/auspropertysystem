<?php

namespace App\Containers\AppSection\Dashboard\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Dashboard\Actions\CreateDashboardAction;
use App\Containers\AppSection\Dashboard\Actions\DeleteDashboardAction;
use App\Containers\AppSection\Dashboard\Actions\FindDashboardByIdAction;
use App\Containers\AppSection\Dashboard\Actions\GetAllDashboardsAction;
use App\Containers\AppSection\Dashboard\Actions\PartnerClientDashboardAction;
use App\Containers\AppSection\Dashboard\Actions\UpdateDashboardAction;
use App\Containers\AppSection\Dashboard\UI\API\Requests\CreateDashboardRequest;
use App\Containers\AppSection\Dashboard\UI\API\Requests\DeleteDashboardRequest;
use App\Containers\AppSection\Dashboard\UI\API\Requests\FindDashboardByIdRequest;
use App\Containers\AppSection\Dashboard\UI\API\Requests\GetAllDashboardsRequest;
use App\Containers\AppSection\Dashboard\UI\API\Requests\UpdateDashboardRequest;
use App\Containers\AppSection\Dashboard\UI\API\Transformers\DashboardTransformer;
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
     * @param CreateDashboardRequest $request
     * @return JsonResponse
     * @throws InvalidTransformerException
     * @throws CreateResourceFailedException
     */
    public function createDashboard(CreateDashboardRequest $request): JsonResponse
    {
        $dashboard = app(CreateDashboardAction::class)->run($request);

        return $this->created($this->transform($dashboard, DashboardTransformer::class));
    }

    /**
     * @param FindDashboardByIdRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws NotFoundException
     */
    public function findDashboardById(FindDashboardByIdRequest $request): array
    {
        $dashboard = app(FindDashboardByIdAction::class)->run($request);

        return $this->transform($dashboard, DashboardTransformer::class);
    }

    /**
     * @param GetAllDashboardsRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function getAllDashboards(GetAllDashboardsRequest $request)
    {
        $dashboards = app(GetAllDashboardsAction::class)->run($request);
        return $dashboards;
    }

    public function PartnerClientDashboard(FindDashboardByIdRequest $request)
    {
        $dashboards = app(PartnerClientDashboardAction::class)->run($request);
        return $dashboards;
    }

    /**
     * @param UpdateDashboardRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws UpdateResourceFailedException
     */
    public function updateDashboard(UpdateDashboardRequest $request): array
    {
        $dashboard = app(UpdateDashboardAction::class)->run($request);

        return $this->transform($dashboard, DashboardTransformer::class);
    }

    /**
     * @param DeleteDashboardRequest $request
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function deleteDashboard(DeleteDashboardRequest $request): JsonResponse
    {
        app(DeleteDashboardAction::class)->run($request);

        return $this->noContent();
    }
}
