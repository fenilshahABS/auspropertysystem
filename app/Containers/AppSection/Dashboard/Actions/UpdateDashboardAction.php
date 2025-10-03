<?php

namespace App\Containers\AppSection\Dashboard\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Dashboard\Models\Dashboard;
use App\Containers\AppSection\Dashboard\Tasks\UpdateDashboardTask;
use App\Containers\AppSection\Dashboard\UI\API\Requests\UpdateDashboardRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateDashboardAction extends ParentAction
{
    /**
     * @param UpdateDashboardRequest $request
     * @return Dashboard
     * @throws UpdateResourceFailedException
     * @throws IncorrectIdException
     * @throws NotFoundException
     */
    public function run(UpdateDashboardRequest $request): Dashboard
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        return app(UpdateDashboardTask::class)->run($data, $request->id);
    }
}
