<?php

namespace App\Containers\AppSection\Expensemanagement\Actions;

use App\Containers\AppSection\Expensemanagement\Tasks\DeleteExpensemanagementTask;
use App\Containers\AppSection\Expensemanagement\UI\API\Requests\DeleteExpensemanagementRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteExpensemanagementAction extends ParentAction
{
    /**
     * @param DeleteExpensemanagementRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteExpensemanagementRequest $request)
    {
        return app(DeleteExpensemanagementTask::class)->run($request->id);
    }
}
