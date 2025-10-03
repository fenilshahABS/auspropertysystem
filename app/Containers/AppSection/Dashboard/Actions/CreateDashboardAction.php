<?php

namespace App\Containers\AppSection\Dashboard\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Dashboard\Models\Dashboard;
use App\Containers\AppSection\Dashboard\Tasks\CreateDashboardTask;
use App\Containers\AppSection\Dashboard\UI\API\Requests\CreateDashboardRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateDashboardAction extends ParentAction
{
    /**
     * @param CreateDashboardRequest $request
     * @return Dashboard
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(CreateDashboardRequest $request): Dashboard
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        return app(CreateDashboardTask::class)->run($data);
    }
}
