<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Containers\AppSection\TaskManagement\Tasks\UpdateTaskManagementByFieldsTask;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\UpdateTaskManagementRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateTaskManagementByFieldsAction extends ParentAction
{

    public function run(UpdateTaskManagementRequest $request, $InputData)
    {
        $data = $request->sanitizeInput([
            "status" => $InputData->getStatus(),
        ]);
        return app(UpdateTaskManagementByFieldsTask::class)->run($data, $request->id);
    }
}
