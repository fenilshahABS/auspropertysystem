<?php

namespace App\Containers\AppSection\Expensemanagement\Actions;

use App\Containers\AppSection\Expensemanagement\Models\Expensemanagement;
use App\Containers\AppSection\Expensemanagement\Tasks\FindExpensemanagementByIdTask;
use App\Containers\AppSection\Expensemanagement\UI\API\Requests\FindExpensemanagementByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindExpensemanagementByIdAction extends ParentAction
{
    /**
     * @throws NotFoundException
     */
    public function run(FindExpensemanagementByIdRequest $request)
    {
        return app(FindExpensemanagementByIdTask::class)->run($request->id);
    }
}
