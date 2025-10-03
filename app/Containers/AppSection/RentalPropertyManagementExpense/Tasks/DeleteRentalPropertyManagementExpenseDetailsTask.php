<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Tasks;

use App\Containers\AppSection\RentalPropertyManagementExpense\Data\Repositories\RentalPropertyManagementExpenseRepository;

use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpenseDetails;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteRentalPropertyManagementExpenseDetailsTask extends ParentTask
{
    public function __construct(
        protected RentalPropertyManagementExpenseRepository $repository
    ) {
    }


    public function run($id)
    {
        try {
            $delete_expense_details = RentalPropertyManagementExpenseDetails::where('id', $id)->delete();
            $returnData = array();
            if ($delete_expense_details) {
                $returnData['message'] = "Data Deleted Successfully";
            } else {
                $returnData['message'] = "Failed To Delete";
            }
            return $returnData;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
