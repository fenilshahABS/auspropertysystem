<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Actions;

use App\Containers\AppSection\RentalPropertyManagementExpense\Tasks\DeleteRentalPropertyManagementWorkerDetailsTask;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\GetAllRentalPropertyManagementExpensesRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Apiato\Core\Traits\HashIdTrait;
use App\Ship\Parents\Requests\Request;

class DeleteRentalPropertyManagementWorkerDetailsAction extends ParentAction
{
    use HashIdTrait;
    /**
     * @param GetAllRentalPropertyManagementExpensesRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(Request $request,$InputData)
    {
        $id = $this->decode($InputData->getWorkerId());
        return app(DeleteRentalPropertyManagementWorkerDetailsTask::class)->run($id);
    }
}
