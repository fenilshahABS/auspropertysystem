<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Transformers;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpenseDetails;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpenseWorkerDetails;
use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class RentalPropertyManagementExpenseTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];
    use HashIdTrait;
    public function transform(RentalPropertyManagementExpense $rentalpropertymanagementexpense): array
    {
        // $response = [
        //     'object' => $rentalpropertymanagementexpense->getResourceKey(),
        //     'id' => $rentalpropertymanagementexpense->getHashedKey(),
        // ];

        $image_api_url = Themesettings::select('image_api_url')->where('id', 1)->first();

        $rentalpropertymanagement_expense_detail = RentalPropertyManagementExpenseDetails::where('pro_rentals_property_management_expense_id', $rentalpropertymanagementexpense->id)->get();
        $returnDetails = array();
        if (!empty($rentalpropertymanagement_expense_detail) && count($rentalpropertymanagement_expense_detail)) {
            for ($i = 0; $i < count($rentalpropertymanagement_expense_detail); $i++) {
                $returnDetails[$i]['id'] = $this->encode($rentalpropertymanagement_expense_detail[$i]->id);
                $returnDetails[$i]['pro_rentals_property_management_expense_id'] = $this->encode($rentalpropertymanagement_expense_detail[$i]->pro_rentals_property_management_expense_id);
                $returnDetails[$i]['expense_management_master_id'] = $this->encode($rentalpropertymanagement_expense_detail[$i]->expense_management_master_id);
                $returnDetails[$i]['amount'] = $rentalpropertymanagement_expense_detail[$i]->amount;
                $returnDetails[$i]['is_tax_applied'] = $rentalpropertymanagement_expense_detail[$i]->is_tax_applied;
                $returnDetails[$i]['tax'] = $rentalpropertymanagement_expense_detail[$i]->tax;
                $returnDetails[$i]['tax_amount'] = $rentalpropertymanagement_expense_detail[$i]->tax_amount;
                $returnDetails[$i]['description'] = $rentalpropertymanagement_expense_detail[$i]->description;
                $returnDetails[$i]['property_damage_image_1'] = ($rentalpropertymanagement_expense_detail[$i]->property_damage_image_1) ? $image_api_url->image_api_url . $rentalpropertymanagement_expense_detail[$i]->property_damage_image_1 : "";
                $returnDetails[$i]['property_damage_image_2'] = ($rentalpropertymanagement_expense_detail[$i]->property_damage_image_2) ? $image_api_url->image_api_url . $rentalpropertymanagement_expense_detail[$i]->property_damage_image_2 : "";
            }
        } else {
            $returnDetails = [];
        }

        $rentalpropertymanagement_worker_detail = RentalPropertyManagementExpenseWorkerDetails::where('pro_rentals_property_management_expense_id', $rentalpropertymanagementexpense->id)->get();
        $returnWorkerDetails = array();
        if (!empty($rentalpropertymanagement_worker_detail) && count($rentalpropertymanagement_worker_detail)) {
            for ($i = 0; $i < count($rentalpropertymanagement_worker_detail); $i++) {
                $returnWorkerDetails[$i]['id'] = $this->encode($rentalpropertymanagement_worker_detail[$i]->id);
                $returnWorkerDetails[$i]['pro_rentals_property_management_expense_id'] = $this->encode($rentalpropertymanagement_worker_detail[$i]->pro_rentals_property_management_expense_id);
                $returnWorkerDetails[$i]['worker_id'] = $this->encode($rentalpropertymanagement_worker_detail[$i]->worker_id);
                $returnWorkerDetails[$i]['worker_name'] = NULL;
                $returnWorkerDetails[$i]['worker_email'] = NULL;
                $returnWorkerDetails[$i]['worker_mobile_no'] = NULL;
                $workerData = Workermaster::where('id',$rentalpropertymanagement_worker_detail[$i]->worker_id)->first();
                if(!empty($workerData)){
                  $returnWorkerDetails[$i]['worker_name'] = $workerData->worker_name;
                  $returnWorkerDetails[$i]['worker_email'] = $workerData->worker_email;
                  $returnWorkerDetails[$i]['worker_mobile_no'] = $workerData->worker_mobile_no;
                }
                $returnWorkerDetails[$i]['worker_amount'] = $rentalpropertymanagement_worker_detail[$i]->worker_amount;
                $returnWorkerDetails[$i]['worker_amount_paid_status'] = $rentalpropertymanagement_worker_detail[$i]->worker_amount_paid_status;
                $returnWorkerDetails[$i]['worker_amount_paid_transaction'] = $rentalpropertymanagement_worker_detail[$i]->worker_amount_paid_transaction;
                $returnWorkerDetails[$i]['worker_amount_paid_date'] = $rentalpropertymanagement_worker_detail[$i]->worker_amount_paid_date;
                $returnWorkerDetails[$i]['worker_notes'] = $rentalpropertymanagement_worker_detail[$i]->worker_notes;
                $returnWorkerDetails[$i]['worker_amount_type'] = $rentalpropertymanagement_worker_detail[$i]['worker_amount_type'];
            }
        } else {
            $returnWorkerDetails = [];
        }

        $response = [
            'object' => $rentalpropertymanagementexpense->getResourceKey(),
            'id' => $rentalpropertymanagementexpense->getHashedKey(),
            'pro_rentals_property_management_id' => $this->encode($rentalpropertymanagementexpense->pro_rentals_property_management_id),
            'status' => $rentalpropertymanagementexpense->status,
            'amount_type' => $rentalpropertymanagementexpense->amount_type,
            'worker_amount_type' => $rentalpropertymanagementexpense->worker_amount_type,
            'total_amount' => $rentalpropertymanagementexpense->total_amount,
            'amount_receive_status' => $rentalpropertymanagementexpense->amount_receive_status,
            'amount_receive_transaction' => $rentalpropertymanagementexpense->amount_receive_transaction,
            'amount_recieve_date' => $rentalpropertymanagementexpense->amount_recieve_date,
            'amount_commission' => $rentalpropertymanagementexpense->amount_commission,
            'rentalpropertymanagement_expense_detail' => $returnDetails,
            'rentalpropertymanagement_worker_details' => $returnWorkerDetails,
            'due_date' => $rentalpropertymanagementexpense->due_date,
            // 'tax_amount' => $rentalpropertymanagementexpense->tax_amount,
        ];
        return $response;
        // return $this->ifAdmin([
        //     'real_id' => $rentalpropertymanagementexpense->id,
        //     'created_at' => $rentalpropertymanagementexpense->created_at,
        //     'updated_at' => $rentalpropertymanagementexpense->updated_at,
        //     'readable_created_at' => $rentalpropertymanagementexpense->created_at->diffForHumans(),
        //     'readable_updated_at' => $rentalpropertymanagementexpense->updated_at->diffForHumans(),
        //     // 'deleted_at' => $rentalpropertymanagementexpense->deleted_at,
        // ], $response);
    }
}
