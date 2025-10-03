<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Actions;

use App\Containers\AppSection\RentalPropertyManagementExpense\Tasks\DeleteRentalPropertyManagementExpenseDetailsTask;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\DeleteRentalPropertyManagementExpenseRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class   DeleteRentalPropertyManagementExpenseDetailsAction extends ParentAction
{
    /**
     * @param DeleteRentalPropertyManagementExpenseRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteRentalPropertyManagementExpenseRequest $request)
    {
        return app(DeleteRentalPropertyManagementExpenseDetailsTask::class)->run($request->id);
    }
}
