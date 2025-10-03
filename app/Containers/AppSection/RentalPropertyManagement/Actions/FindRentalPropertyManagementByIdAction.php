<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Actions;

use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagement\Tasks\FindRentalPropertyManagementByIdTask;
use App\Containers\AppSection\RentalPropertyManagement\UI\API\Requests\FindRentalPropertyManagementByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindRentalPropertyManagementByIdAction extends ParentAction
{
    /**
     * @throws NotFoundException
     */
    public function run(FindRentalPropertyManagementByIdRequest $request): RentalPropertyManagement
    {
        return app(FindRentalPropertyManagementByIdTask::class)->run($request->id);
    }
}
