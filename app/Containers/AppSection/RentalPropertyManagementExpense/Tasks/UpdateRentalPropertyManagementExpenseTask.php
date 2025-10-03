<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Tasks;

use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagementExpense\Data\Repositories\RentalPropertyManagementExpenseRepository;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpenseDetails;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpenseWorkerDetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateRentalPropertyManagementExpenseTask extends ParentTask
{
    public function __construct(
        protected RentalPropertyManagementExpenseRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($data, $id, $rent_property_expense_details,$worker_details)
    {
        try {

            $update = $this->repository->update($data, $id);

            if ($data['status'] == 1) {
                $property_rental_data = RentalPropertyManagement::select(
                    'property_master_id',
                    'pro_property_master_details_id'
                )->where('id', $data['pro_rentals_property_management_id'])->first();
                $update_property_to_rent = PropertymasterDetails::where('id', $property_rental_data->pro_property_master_details_id)->update(["property_status" => 2]);
            }

            for ($i = 0; $i < count($rent_property_expense_details); $i++) {
                if (isset($rent_property_expense_details[$i]['id'])) {
                    $update_expense_details = RentalPropertyManagementExpenseDetails::where('id', $rent_property_expense_details[$i]['id'])->update($rent_property_expense_details[$i]);
                } else {
                    $rent_property_expense_details[$i]['pro_rentals_property_management_expense_id'] = $id;
                    $update_expense_details = RentalPropertyManagementExpenseDetails::create($rent_property_expense_details[$i]);
                }
            }

            for ($w = 0; $w < count($worker_details); $w++) {
              if (isset($worker_details[$w]['id'])) {
                  $update_expense_details = RentalPropertyManagementExpenseWorkerDetails::where('id', $worker_details[$w]['id'])->update($worker_details[$w]);
              } else {
                  $worker_details[$w]['pro_rentals_property_management_expense_id'] = $id;
                  $update_expense_details = RentalPropertyManagementExpenseWorkerDetails::create($worker_details[$w]);
              }
            }

            return $update;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
