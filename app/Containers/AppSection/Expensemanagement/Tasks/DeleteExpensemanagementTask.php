<?php

namespace App\Containers\AppSection\Expensemanagement\Tasks;

use App\Containers\AppSection\Expensemanagement\Data\Repositories\ExpensemanagementRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteExpensemanagementTask extends ParentTask
{
    public function __construct(
        protected ExpensemanagementRepository $repository
    ) {
    }

    /**
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run($id)
    {
        try {

            $delete = $this->repository->delete($id);
            $returnData = array();
            if ($delete) {
                $returnData['message'] = "Data deleted Succesfully";
            } else {
                $returnData['message'] = "Failed to delete";
            }
            return $returnData;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
