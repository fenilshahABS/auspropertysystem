<?php

namespace App\Containers\AppSection\Expensemanagement\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Expensemanagement\Models\Expensemanagement;
use App\Containers\AppSection\Expensemanagement\Tasks\UpdateExpensemanagementTask;
use App\Containers\AppSection\Expensemanagement\UI\API\Requests\UpdateExpensemanagementRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateExpensemanagementAction extends ParentAction
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
        $data = $request->sanitizeInput([
            'type' => $InputData->getType(),
        ]);
        $data = array_filter($data);


        return app(UpdateExpensemanagementTask::class)->run($data, $request->id);
    }
}
