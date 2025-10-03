<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Tasks;

use App\Containers\AppSection\RentalPropertyManagementExpense\Data\Repositories\RentalPropertyManagementExpenseRepository;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpenseDetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateRentalPropertyManagementExpenseByFieldsTask extends ParentTask
{
    public function __construct(
        protected RentalPropertyManagementExpenseRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($InputData, $id)
    {
        //try {
        $field_db = $InputData->getFieldDB();
        $search_val = $InputData->getSearchVal();

        if ($field_db == "tax") {
            $update = RentalPropertyManagementExpense::where('id', $id)->first();
            $tax_amount = $update->total_amount * ($search_val / 100);
            $update->tax = $search_val;
            $update->tax_amount = $tax_amount;
            $update->save();
        } else {
            $update = RentalPropertyManagementExpense::where('id', $id)->update([$field_db => $search_val]);
        }
        if ($update) {
            return $this->repository->find($id);
        } else {
            return $returnData['message'] = "Failed To Update";
        }
        // } catch (ModelNotFoundException) {
        //     throw new NotFoundException();
        // } catch (Exception) {
        //     throw new UpdateResourceFailedException();
        // }
    }
}
