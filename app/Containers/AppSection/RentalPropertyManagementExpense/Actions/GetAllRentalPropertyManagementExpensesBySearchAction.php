<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\RentalPropertyManagementExpense\Tasks\GetAllRentalPropertyManagementExpensesBySearchTask;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\GetAllRentalPropertyManagementExpensesRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalPropertyManagementExpensesBySearchAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllRentalPropertyManagementExpensesRequest $request, $InputData)
    {
        return app(GetAllRentalPropertyManagementExpensesBySearchTask::class)->run($InputData, $request);
    }
}
