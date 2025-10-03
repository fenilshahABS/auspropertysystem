<?php

namespace App\Containers\AppSection\Expensemanagement\Tasks;

use App\Containers\AppSection\Expensemanagement\Data\Repositories\ExpensemanagementRepository;
use App\Containers\AppSection\Expensemanagement\Models\Expensemanagement;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class FindExpensemanagementByIdTask extends ParentTask
{
    public function __construct(
        protected ExpensemanagementRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function run($id)
    {
        try {
            return $this->repository->find($id);
        } catch (Exception) {
            throw new NotFoundException();
        }
    }
}
