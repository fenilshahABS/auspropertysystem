<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Containers\AppSection\RentalPropertyManagementExpense\Tasks\CreateRentalPropertyManagementExpenseTask;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\CreateRentalPropertyManagementExpenseRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CreateRentalPropertyManagementExpenseAction extends ParentAction
{
    use HashIdTrait;
    public function run(CreateRentalPropertyManagementExpenseRequest $request, $InputData)
    {



        $data = $request->sanitizeInput([
            // "pro_rentals_property_management_id" => $InputData->getProRentalsPropertyManagementId(),
            //"worker_name" => $InputData->getWorkerName(),
            //"worker_email" => $InputData->getWorkerEmail(),
            //"worker_amount" => $InputData->getWorkerAmount(),
            //"worker_amount_paid_status" => $InputData->getWorkerAmountPaidStatus(),
            //"worker_amount_paid_transaction" => $InputData->getWorkerAmountPaidTransaction(),
            //"worker_notes" => $InputData->getWorkerNotes(),
            //"worker_amount_paid_date" => $InputData->getworkerAmountPaidDate(),
            "amount_recieve_date" => $InputData->getAmountRecieveDate(),
            "status" => $InputData->getStatus(),
            "total_amount" => $InputData->getTotalAmount(),
            "amount_type" => $InputData->getAmountType(),
            //"worker_amount_type" => $InputData->getWorkerAmountType(),
            "due_date" => $InputData->getDueDate(),
            "amount_receive_transaction" => $InputData->getAmountReceiveTransaction(),
            "amount_receive_status" => $InputData->getAmountReceiveStatus(),
            "amount_commission" => $InputData->getAmountCommission(),
        ]);
        $data['pro_rentals_property_management_id'] = $this->decode($InputData->getProRentalsPropertyManagementId());
        //$data['worker_mobile_no'] = (string)$InputData->getWorkerMobileNo();

        $expense_details = $InputData->getExpenseDetails();
        if (!empty($expense_details)) {
            for ($j = 0; $j < count($expense_details); $j++) {

                $imagearray = array();
                $imagearray['property_damage_image_1'] = $expense_details[$j]['property_damage_image_1'];
                $imagearray['property_damage_image_2'] = $expense_details[$j]['property_damage_image_2'];
                $image_upload = [];
                $save_data_image = [];

                foreach ($imagearray as $imagearray_key => $imagearray_value) {
                    if (isset($imagearray[$imagearray_key]) && $imagearray[$imagearray_key] != null) {
                        $manager = new ImageManager(Driver::class);
                        $image = $manager->read($imagearray_value);
                        if (!file_exists(public_path($imagearray_key . '/'))) {
                            mkdir(public_path($imagearray_key . '/'), 0755, true);
                        }
                        $image_type = "png";
                        $folderPath = 'public/' . $imagearray_key . '/';
                        $file =  uniqid() . '.' . $image_type;
                        $saveimage = $image->toPng()->save(public_path($imagearray_key . '/' . $file));
                        $image_upload[$imagearray_key] =   $folderPath . $file;
                    } else {
                        $image_upload[$imagearray_key] = '';
                    }
                    $save_data_image = $image_upload;
                }
                $tax = $InputData->getTax();
                if ($tax == 0) {
                    $tax_amount = 0;
                } else {
                    $tax_amount = $InputData->getTotalAmount() * ($tax / 100);
                }

                $rent_property_expense_details[$j] = [
                    "amount" => $expense_details[$j]['amount'],
                    "description" => $expense_details[$j]['description'] ?? "",
                    "is_tax_applied" => $expense_details[$j]['is_tax_applied'],
                    "tax" => $expense_details[$j]['tax'],
                    "tax_amount" => $expense_details[$j]['tax_amount'],
                    // "property_damage_image_2" => $expense_details[$j]['property_damage_image_2']
                ];
                $rent_property_expense_details[$j]['property_damage_image_1'] = $save_data_image['property_damage_image_1'];
                $rent_property_expense_details[$j]['property_damage_image_2'] = $save_data_image['property_damage_image_2'];
                $rent_property_expense_details[$j]['expense_management_master_id'] = $this->decode($expense_details[$j]['expense_management_master_id']);
            }
        }

        $worker_details = $InputData->getWorkerDetails();
        if (!empty($worker_details)) {
            for ($w = 0; $w < count($worker_details); $w++) {
              if(!empty($worker_details[$w]['worker_amount_paid_date'])){
                $worker_amount_paid_date = $worker_details[$w]['worker_amount_paid_date'];
              }else{
                $worker_amount_paid_date = NULL;
              }
              //echo $this->decode($worker_details[$w]['worker_id']);die;
              $worker_details[$w]['worker_id'] = $this->decode($worker_details[$w]['worker_id']);
              $worker_details[$w]['worker_amount'] = $worker_details[$w]['worker_amount'];
              $worker_details[$w]['worker_amount_paid_status '] = $worker_details[$w]['worker_amount_paid_status'];
              $worker_details[$w]['worker_amount_paid_transaction'] = $worker_details[$w]['worker_amount_paid_transaction'];
              $worker_details[$w]['worker_amount_paid_date'] = $worker_amount_paid_date;
              $worker_details[$w]['worker_notes'] = $worker_details[$w]['worker_notes'];
              $worker_details[$w]['worker_amount_type'] = $worker_details[$w]['worker_amount_type'];
            }
        }



        return app(CreateRentalPropertyManagementExpenseTask::class)->run($data, $rent_property_expense_details,$worker_details);
    }
}
