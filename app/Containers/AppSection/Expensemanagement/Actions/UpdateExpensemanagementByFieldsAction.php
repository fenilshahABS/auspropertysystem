<?php

namespace App\Containers\AppSection\Expensemanagement\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Expensemanagement\Models\Expensemanagement;
use App\Containers\AppSection\Expensemanagement\Tasks\UpdateExpensemanagementByFieldsTask;
use App\Containers\AppSection\Expensemanagement\UI\API\Requests\UpdateExpensemanagementRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateExpensemanagementByFieldsAction extends ParentAction
{
    /**
     * @param UpdateExpensemanagementRequest $request
     * @return Expensemanagement
     * @throws UpdateResourceFailedException
     * @throws IncorrectIdException
     * @throws NotFoundException
     */
    public function run(UpdateExpensemanagementRequest $request, $InputData)
    {
        return app(UpdateExpensemanagementByFieldsTask::class)->run($request->id, $InputData);
    }
}
