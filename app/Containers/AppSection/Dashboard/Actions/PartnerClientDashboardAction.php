<?php

namespace App\Containers\AppSection\Dashboard\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Dashboard\Tasks\PartnerClientDashboardTask;
use App\Containers\AppSection\Dashboard\UI\API\Requests\FindDashboardByIdRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class PartnerClientDashboardAction extends ParentAction
{

    public function run(FindDashboardByIdRequest $request)
    {
        return app(PartnerClientDashboardTask::class)->run($request->id);
    }
}
