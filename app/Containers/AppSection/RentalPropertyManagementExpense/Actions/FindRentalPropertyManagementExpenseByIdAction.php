<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Actions;

use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Containers\AppSection\RentalPropertyManagementExpense\Tasks\FindRentalPropertyManagementExpenseByIdTask;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\FindRentalPropertyManagementExpenseByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindRentalPropertyManagementExpenseByIdAction extends ParentAction
{
    /**
     * @throws NotFoundException
     */
    public function run(FindRentalPropertyManagementExpenseByIdRequest $request)
    {
        return app(FindRentalPropertyManagementExpenseByIdTask::class)->run($request->id);
    }
}
