<?php

namespace App\Containers\AppSection\Dashboard\Actions;

use App\Containers\AppSection\Dashboard\Models\Dashboard;
use App\Containers\AppSection\Dashboard\Tasks\FindDashboardByIdTask;
use App\Containers\AppSection\Dashboard\UI\API\Requests\FindDashboardByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindDashboardByIdAction extends ParentAction
{
    /**
     * @throws NotFoundException
     */
    public function run(FindDashboardByIdRequest $request): Dashboard
    {
        return app(FindDashboardByIdTask::class)->run($request->id);
    }
}
