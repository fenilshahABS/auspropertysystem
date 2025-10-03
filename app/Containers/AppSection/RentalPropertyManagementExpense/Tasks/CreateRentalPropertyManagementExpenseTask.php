<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Tasks;

use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagementExpense\Data\Repositories\RentalPropertyManagementExpenseRepository;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpenseDetails;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpenseWorkerDetails;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreateRentalPropertyManagementExpenseTask extends ParentTask
{
    public function __construct(
        protected RentalPropertyManagementExpenseRepository $repository
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run($data, $rent_property_expense_details,$worker_details)
    {
        try {

            $create_rental_property_expense = $this->repository->create($data);
            $get_property_master_detail_id = RentalPropertyManagement::select('pro_property_master_details_id')
                ->where('id', $create_rental_property_expense->pro_rentals_property_management_id)
                ->first();
            $update_rental_property_details = PropertymasterDetails::where('id', $get_property_master_detail_id->pro_property_master_details_id)
                ->update(["property_status" => 9]);

            for ($i = 0; $i < count($rent_property_expense_details); $i++) {
                $rent_property_expense_details[$i]['pro_rentals_property_management_expense_id'] = $create_rental_property_expense->id;

                $create_rental_property_late_fees = RentalPropertyManagementExpenseDetails::create($rent_property_expense_details[$i]);
            }

            for ($w = 0; $w < count($worker_details); $w++) {
                $worker_details[$w]['pro_rentals_property_management_expense_id'] = $create_rental_property_expense->id;
                $create_rental_property_late_fees = RentalPropertyManagementExpenseWorkerDetails::create($worker_details[$w]);
            }

            return $create_rental_property_expense;
        } catch (Exception) {
            throw new CreateResourceFailedException();
        }
    }
}
