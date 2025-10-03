<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Actions;

use App\Containers\AppSection\RentalPropertyManagement\Tasks\DeleteRentalPropertyManagementTask;
use App\Containers\AppSection\RentalPropertyManagement\UI\API\Requests\DeleteRentalPropertyManagementRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteRentalPropertyManagementAction extends ParentAction
{
    /**
     * @param DeleteRentalPropertyManagementRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteRentalPropertyManagementRequest $request)
    {
        return app(DeleteRentalPropertyManagementTask::class)->run($request->id);
    }
}
