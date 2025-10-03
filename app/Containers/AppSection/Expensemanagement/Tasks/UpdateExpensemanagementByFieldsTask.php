<?php

namespace App\Containers\AppSection\Expensemanagement\Tasks;

use App\Containers\AppSection\Expensemanagement\Data\Repositories\ExpensemanagementRepository;
use App\Containers\AppSection\Expensemanagement\Models\Expensemanagement;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateExpensemanagementByFieldsTask extends ParentTask
{
    public function __construct(
        protected ExpensemanagementRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($id, $InputData)
    {
        try {
            $returnData = array();
            $is_active = $InputData->getIsActive();
            $update = Expensemanagement::where('id', $id)->update(["is_active" => $is_active]);
            if ($update) {
                $returnData['message'] = "Data Updated Succesfully";
            } else {
                $returnData['message'] = "Failed to update";
            }
            return $returnData;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
