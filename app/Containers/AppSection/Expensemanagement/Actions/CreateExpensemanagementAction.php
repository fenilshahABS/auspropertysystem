<?php

namespace App\Containers\AppSection\Expensemanagement\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Expensemanagement\Models\Expensemanagement;
use App\Containers\AppSection\Expensemanagement\Tasks\CreateExpensemanagementTask;
use App\Containers\AppSection\Expensemanagement\UI\API\Requests\CreateExpensemanagementRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateExpensemanagementAction extends ParentAction
{
    /**
     * @param CreateExpensemanagementRequest $request
     * @return Expensemanagement
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(CreateExpensemanagementRequest $request, $InputData)
    {
        $data = $request->sanitizeInput([
            'type' => $InputData->getType(),
            'is_active' => 1
        ]);


        return app(CreateExpensemanagementTask::class)->run($data);
    }
}
