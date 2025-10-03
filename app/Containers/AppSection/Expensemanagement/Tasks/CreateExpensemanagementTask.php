<?php

namespace App\Containers\AppSection\Expensemanagement\Tasks;

use App\Containers\AppSection\Expensemanagement\Data\Repositories\ExpensemanagementRepository;
use App\Containers\AppSection\Expensemanagement\Models\Expensemanagement;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreateExpensemanagementTask extends ParentTask
{
    public function __construct(
        protected ExpensemanagementRepository $repository
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (Exception) {
            throw new CreateResourceFailedException();
        }
    }
}
