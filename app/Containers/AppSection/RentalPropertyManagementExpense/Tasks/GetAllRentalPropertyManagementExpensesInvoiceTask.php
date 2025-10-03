<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Expensemanagement\Models\Expensemanagement;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagementExpense\Data\Repositories\RentalPropertyManagementExpenseRepository;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpenseDetails;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpenseWorkerDetails;
use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalPropertyManagementExpensesInvoiceTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RentalPropertyManagementExpenseRepository $repository
    ) {
    }

    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run($id)
    {
        try {
            $image_api_url = Themesettings::where('id', 1)->first();
            $getData = RentalPropertyManagementExpense::select('pro_rentals_property_management_expense.*')
                ->where('id', $id)->first();

            $returnData = array();
            $returnDetails = array();
            if (!empty($getData)) {
                $returnData['message'] = "Data Found";
                // for ($i = 0; $i < count($getData); $i++) {
                ($getData->image) ? $image_api_url->image_api_url . $getData->image : "";
                $returnData['data']['object'] = "pro_rentals_property_management_expense";
                $returnData['data']['id'] = $this->encode($getData['id']);
                $returnData['data']['serial_no'] = $getData['id'];
                $returnData['data']['company_name'] = $image_api_url->name;
                $returnData['data']['company_address'] = $image_api_url->address;
                $returnData['data']['company_email'] = $image_api_url->email;
                //$returnData['data']['worker_amount_paid_date'] = $getData['worker_amount_paid_date'];

                $property_master_data  = RentalPropertyManagement::select('property_master_id', 'pro_property_master_details_id')->where('id', $getData['pro_rentals_property_management_id'])->first();
                if (!empty($property_master_data)) {
                    $property_name = Propertymaster::select(
                        'property_name',
                        'firm_name',
                        'property_address_1',
                        'property_address_2',
                        'property_state'
                    )->where('id', $property_master_data->property_master_id)->first();
                }
                $property_owner_details = PropertymasterShareDetails::where('pro_property_master_id', $property_master_data->property_master_id)->get();
                if (!empty($property_owner_details)) {
                    //    for ($i = 0; $i < count($property_owner_details); $i++) {
                    // $reciever_data = Tenantusers::where('id', $property_owner_details[$i]->property_owner_id)->first();
                    $returnData['reciever_data'][0]['receiver_name'] = $property_name->firm_name ?? "";
                    $returnData['reciever_data'][0]['receiver_add'] = $property_name->property_address_1 . ' ' . $property_name->property_address_2 ?? "";
                    $returnData['reciever_data'][0]['receiver_state'] =  $property_name->property_state ?? "";
                    //      }
                } else {
                    $returnData['reciever_data'][0]['receiver_name'] = "";
                    $returnData['reciever_data'][0]['receiver_add'] =  "";
                    $returnData['reciever_data'][0]['receiver_state'] = "";
                }


                $returnData['data']['term'] = "Net 30";

                $returnData['data']['pro_rentals_property_management_id'] = $this->encode($getData['pro_rentals_property_management_id']);


                // $property_master_data  = RentalPropertyManagement::select('property_master_id', 'pro_property_master_details_id')->where('id', $getData['pro_rentals_property_management_id'])->first();
                // if (!empty($property_master_data)) {
                //     $property_name = Propertymaster::select('property_name')->where('id', $property_master_data->property_master_id)->first();
                // }
                if (!empty($property_master_data)) {
                    $property_unit_name = PropertymasterDetails::select('units_name')->where('id', $property_master_data->pro_property_master_details_id)->first();
                }
                $returnData['data']['property_name'] = $property_name->property_name ?? "";
                $returnData['data']['firm_name'] = $property_name->firm_name ?? "";
                $returnData['data']['property_address_1'] = $property_name->property_address_1 ?? "";
                $returnData['data']['property_address_2'] = $property_name->property_address_2 ?? "";
                $returnData['data']['property_unit_name'] = $property_unit_name->units_name ?? "";
                /*
                $returnData['data']['worker_name'] = $getData['worker_name'];
                $returnData['data']['worker_mobile_no'] = $getData['worker_mobile_no'];
                $returnData['data']['worker_email'] = $getData['worker_email'];
                $returnData['data']['worker_amount'] = $getData['worker_amount'];
                $returnData['data']['worker_amount_paid_status'] = $getData['worker_amount_paid_status'];
                $returnData['data']['worker_amount_paid_transaction'] = $getData['worker_amount_paid_transaction'];
                $returnData['data']['worker_notes'] = $getData['worker_notes'];
                */
                $returnData['data']['status'] = $getData['status'];
                $returnData['data']['amount_type'] = $getData['amount_type'];
                //$returnData['data']['worker_amount_type'] = $getData['worker_amount_type'];
                $returnData['data']['total_amount'] = $getData['total_amount'];


                $returnData['data']['due_date'] = $getData['due_date'];
                $returnData['data']['amount_recieve_date'] = $getData['amount_recieve_date'];
                $returnData['data']['amount_receive_status'] = $getData['amount_receive_status'];
                $returnData['data']['amount_receive_transaction'] = $getData['amount_receive_transaction'];
                $returnData['data']['amount_commission'] = $getData['amount_commission'];

                $returnData['data']['created_at'] = $getData['created_at'];
                $returnData['data']['updated_at'] = $getData['updated_at'];

                $image_api_url = Themesettings::select('image_api_url')->where('id', 1)->first();

                $rentalpropertymanagement_expense_details = RentalPropertyManagementExpenseDetails::where('pro_rentals_property_management_expense_id', $getData['id'])->get();
                $returnDetails = array();
                if (!empty($rentalpropertymanagement_expense_details) && count($rentalpropertymanagement_expense_details)) {
                    for ($j = 0; $j < count($rentalpropertymanagement_expense_details); $j++) {
                        $returnDetails[$j]['id'] = $this->encode($rentalpropertymanagement_expense_details[$j]->id);
                        $returnDetails[$j]['pro_rentals_property_management_expense_id'] = $this->encode($rentalpropertymanagement_expense_details[$j]->pro_rentals_property_management_expense_id);
                        $returnDetails[$j]['expense_management_master_id'] = $this->encode($rentalpropertymanagement_expense_details[$j]->expense_management_master_id);
                        $expense_name = Expensemanagement::where('id', $rentalpropertymanagement_expense_details[$j]->expense_management_master_id)->first();
                        $returnDetails[$j]['expense_name'] = $expense_name->type ?? "";
                        $returnDetails[$j]['amount'] = $rentalpropertymanagement_expense_details[$j]->amount;
                        $returnDetails[$j]['description'] = $rentalpropertymanagement_expense_details[$j]->description;

                        $returnDetails[$j]['is_tax_applied'] = $rentalpropertymanagement_expense_details[$j]->is_tax_applied;
                        $returnDetails[$j]['tax'] = $rentalpropertymanagement_expense_details[$j]->tax;
                        $returnDetails[$j]['tax_amount'] = $rentalpropertymanagement_expense_details[$j]->tax_amount;

                        $returnDetails[$j]['property_damage_image_1'] = ($rentalpropertymanagement_expense_details[$j]->property_damage_image_1) ? $image_api_url->image_api_url . $rentalpropertymanagement_expense_details[$j]->property_damage_image_1 : "";
                        $returnDetails[$j]['property_damage_image_2'] = ($rentalpropertymanagement_expense_details[$j]->property_damage_image_2) ? $image_api_url->image_api_url . $rentalpropertymanagement_expense_details[$j]->property_damage_image_2 : "";
                    }
                } else {
                    $returnDetails = [];
                }
                $returnData['data']['rentalpropertymanagement_expense_details'] = $returnDetails;

                $rentalpropertymanagement_worker_details = RentalPropertyManagementExpenseWorkerDetails::where('pro_rentals_property_management_expense_id', $getData['id'])->get();
                $returnWorkerDetails = array();
                if (!empty($rentalpropertymanagement_worker_details) && count($rentalpropertymanagement_worker_details)) {
                    for ($w = 0; $w < count($rentalpropertymanagement_worker_details); $w++) {
                        $returnWorkerDetails[$w]['id'] = $this->encode($rentalpropertymanagement_worker_details[$w]->id);
                        $returnWorkerDetails[$w]['pro_rentals_property_management_expense_id'] = $this->encode($rentalpropertymanagement_worker_details[$w]->pro_rentals_property_management_expense_id);
                        $returnWorkerDetails[$w]['worker_id'] = $this->encode($rentalpropertymanagement_worker_details[$w]->worker_id);
                        $returnWorkerDetails[$w]['worker_name'] = NULL;
                        $returnWorkerDetails[$w]['worker_email'] = NULL;
                        $returnWorkerDetails[$w]['worker_mobile_no'] = NULL;
                        $workerData = Workermaster::where('id',$rentalpropertymanagement_worker_details[$w]->worker_id)->first();
                        if(!empty($workerData)){
                          $returnWorkerDetails[$w]['worker_name'] = $workerData->worker_name;
                          $returnWorkerDetails[$w]['worker_email'] = $workerData->worker_email;
                          $returnWorkerDetails[$w]['worker_mobile_no'] = $workerData->worker_mobile_no;
                        }
                        $returnWorkerDetails[$w]['worker_amount'] = $rentalpropertymanagement_worker_details[$w]->worker_amount;
                        $returnWorkerDetails[$w]['worker_amount_paid_status '] = $rentalpropertymanagement_worker_details[$w]->worker_amount_paid_status;
                        $returnWorkerDetails[$w]['worker_amount_paid_transaction'] = $rentalpropertymanagement_worker_details[$w]->worker_amount_paid_transaction;
                        $returnWorkerDetails[$w]['worker_amount_paid_date'] = $rentalpropertymanagement_worker_details[$w]->worker_amount_paid_date;
                        $returnWorkerDetails[$w]['worker_notes'] = $rentalpropertymanagement_worker_details[$w]->worker_notes;
                        $returnWorkerDetails[$w]['worker_amount_type'] = $rentalpropertymanagement_worker_details[$w]->worker_amount_type;
                    }
                } else {
                    $returnWorkerDetails = [];
                }
                $returnData['data'][$w]['rentalpropertymanagement_worker_details'] = $returnWorkerDetails;

                //    }
            } else {
                $returnData['message'] = "Data Not Found";
                $returnData['object'] = "pro_rentals_property_management_expense";
            }
            return $returnData;
        } catch (Exception $e) {
            return $e;
        }
    }
}
