<?php

namespace App\Containers\AppSection\Expensemanagement\Tasks;

use App\Containers\AppSection\Expensemanagement\Data\Repositories\ExpensemanagementRepository;
use App\Containers\AppSection\Expensemanagement\Models\Expensemanagement;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateExpensemanagementTask extends ParentTask
{
    public function __construct(
        protected ExpensemanagementRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run(array $data, $id)
    {
        try {
            return $this->repository->update($data, $id);
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
