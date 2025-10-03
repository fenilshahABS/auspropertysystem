<?php

namespace App\Containers\AppSection\Expensemanagement\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Expensemanagement\Tasks\GetAllExpensemanagementsTask;
use App\Containers\AppSection\Expensemanagement\UI\API\Requests\GetAllExpensemanagementsRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllExpensemanagementsAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllExpensemanagementsRequest $request)
    {
        return app(GetAllExpensemanagementsTask::class)->run();
    }
}
