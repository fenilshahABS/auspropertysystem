<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\RentalPropertyManagementExpense\Tasks\GetAllRentalPropertyManagementExpensesInvoiceTask;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\FindRentalPropertyManagementExpenseByIdRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalPropertyManagementExpensesInvoiceAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(FindRentalPropertyManagementExpenseByIdRequest $request)
    {
        return app(GetAllRentalPropertyManagementExpensesInvoiceTask::class)->run($request->id);
    }
}
