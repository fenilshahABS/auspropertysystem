<?php

namespace App\Containers\AppSection\Dashboard\Actions;

use App\Containers\AppSection\Dashboard\Tasks\DeleteDashboardTask;
use App\Containers\AppSection\Dashboard\UI\API\Requests\DeleteDashboardRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteDashboardAction extends ParentAction
{
    /**
     * @param DeleteDashboardRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteDashboardRequest $request): int
    {
        return app(DeleteDashboardTask::class)->run($request->id);
    }
}
