<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagementExpense\Data\Repositories\RentalPropertyManagementExpenseRepository;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpenseDetails;
use App\Containers\AppSection\Expensemanagement\Models\Expensemanagement;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpenseWorkerDetails;

use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;

use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalPropertyManagementExpensesBySearchTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RentalPropertyManagementExpenseRepository $repository
    ) {
    }


    public function run($InputData, $request)
    {
        try {
            $image_api_url = Themesettings::where('id', 1)->first();
            $per_page = (int) $InputData->getPerPage();
            $field_db = $InputData->getFieldDB();
            $search_val = $InputData->getSearchVal();
            $role_id = $this->decode($InputData->getRoleId());
            $user_id="";
            if(!empty($InputData->getUserId())){
              $user_id = $this->decode($InputData->getUserId());
            }

            //echo $user_id;die;

            $pro_property_master_id = "";
            $pro_rentals_property_management_id = "";
            if($user_id!=""){
              // get property id


              $pro_property_master_id_Data = PropertymasterShareDetails::select('pro_property_master_id')->where('property_owner_id',$user_id)->get();
              if(!empty($pro_property_master_id_Data)){
                for($p=0;$p<count($pro_property_master_id_Data);$p++){
                  if($p==0){
                    $pro_property_master_id.= $pro_property_master_id_Data[$p]->pro_property_master_id;
                  }else{
                    $pro_property_master_id.= ",".$pro_property_master_id_Data[$p]->pro_property_master_id;
                  }
                }


                //after rental id
                $RentalPropertyManagementData = RentalPropertyManagement::select('id')->whereIn('property_master_id',explode(',',$pro_property_master_id))->get();
                if(!empty($RentalPropertyManagementData)){
                  for($p=0;$p<count($RentalPropertyManagementData);$p++){
                    if($p==0){
                      $pro_rentals_property_management_id.= $RentalPropertyManagementData[$p]->id;
                    }else{
                      $pro_rentals_property_management_id.= ",".$RentalPropertyManagementData[$p]->id;
                    }
                  }
                 }

              }

            }

            //echo "id :-".$pro_rentals_property_management_id;die;

            if (($field_db == "") || ($field_db == NULL)) {
                if ($request->flag == "dashboard") {
                  if($user_id!=""){
                    $getData = RentalPropertyManagementExpense::whereIn('pro_rentals_property_management_id',explode(',',$pro_rentals_property_management_id))
                                                              ->orderBy('pro_rentals_property_management_expense.created_at', 'DESC')
                                                              ->get();
                  }else{
                    $getData = RentalPropertyManagementExpense::orderBy('pro_rentals_property_management_expense.created_at', 'DESC')->get();
                  }

                } else {
                  if($user_id!=""){
                    $getData = RentalPropertyManagementExpense::whereIn('pro_rentals_property_management_id',explode(',',$pro_rentals_property_management_id))
                                                              ->orderBy('pro_rentals_property_management_expense.created_at', 'DESC')->paginate($per_page);
                  }else{
                    $getData = RentalPropertyManagementExpense::orderBy('pro_rentals_property_management_expense.created_at', 'DESC')->paginate($per_page);
                  }
                }
            } else {
                if ($field_db == "pro_rentals_property_management_id" || $field_db == "id") {
                    if ($field_db == "id") {
                        $field_db = "pro_rentals_property_management_expense.id";
                    }
                    $search_val = $this->decode($search_val);
                }
                if ($request->flag == "dashboard") {
                  if($user_id!=""){
                    $getData = RentalPropertyManagementExpense::select('pro_rentals_property_management_expense.*')
                        ->whereIn('pro_rentals_property_management_id',explode(',',$pro_rentals_property_management_id))
                        ->where($field_db, 'like', '%' . $search_val . '%')
                        ->orderBy('pro_rentals_property_management_expense.created_at', 'DESC')
                        ->get();
                  }else{
                    $getData = RentalPropertyManagementExpense::select('pro_rentals_property_management_expense.*')
                        ->where($field_db, 'like', '%' . $search_val . '%')
                        ->orderBy('pro_rentals_property_management_expense.created_at', 'DESC')
                        ->get();
                  }
                } else {
                  if($user_id!=""){
                    $getData = RentalPropertyManagementExpense::select('pro_rentals_property_management_expense.*')
                        ->where($field_db, 'like', '%' . $search_val . '%')
                        ->whereIn('pro_rentals_property_management_id',explode(',',$pro_rentals_property_management_id))
                        ->orderBy('pro_rentals_property_management_expense.created_at', 'DESC')
                        ->paginate($per_page);
                  }else{
                    $getData = RentalPropertyManagementExpense::select('pro_rentals_property_management_expense.*')
                        ->where($field_db, 'like', '%' . $search_val . '%')
                        ->orderBy('pro_rentals_property_management_expense.created_at', 'DESC')
                        ->paginate($per_page);
                  }
                }
            }
            $returnData = array();
            $returnDetails = array();
            //   $returnShareDetails = array();
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    ($getData[$i]->image) ? $image_api_url->image_api_url . $getData[$i]->image : "";
                    $returnData['data'][$i]['object'] = "pro_rentals_property_management_expense";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                    $returnData['data'][$i]['pro_rentals_property_management_id'] = $this->encode($getData[$i]['pro_rentals_property_management_id']);

                    $property_master_data  = RentalPropertyManagement::select('property_master_id', 'pro_property_master_details_id')->where('id', $getData[$i]['pro_rentals_property_management_id'])->first();
                    if (!empty($property_master_data)) {
                        $property_name = Propertymaster::select('property_name')->where('id', $property_master_data->property_master_id)->first();
                    }
                    if (!empty($property_master_data)) {
                        $property_unit_name = PropertymasterDetails::select('units_name')->where('id', $property_master_data->pro_property_master_details_id)->first();
                    }


                    $returnData['data'][$i]['property_name'] = $property_name->property_name ?? "";
                    $returnData['data'][$i]['property_unit_name'] = $property_unit_name->units_name ?? "";

                    /*
                    $returnData['data'][$i]['worker_name'] = $getData[$i]['worker_name'];
                    $returnData['data'][$i]['worker_mobile_no'] = $getData[$i]['worker_mobile_no'];
                    $returnData['data'][$i]['worker_email'] = $getData[$i]['worker_email'];
                    $returnData['data'][$i]['worker_amount'] = $getData[$i]['worker_amount'];
                    $returnData['data'][$i]['worker_amount_paid_status'] = $getData[$i]['worker_amount_paid_status'];
                    $returnData['data'][$i]['worker_amount_paid_transaction'] = $getData[$i]['worker_amount_paid_transaction'];
                    $returnData['data'][$i]['worker_amount_paid_date'] = $getData[$i]['worker_amount_paid_date'];
                    $returnData['data'][$i]['worker_notes'] = $getData[$i]['worker_notes'];
                    $returnData['data'][$i]['worker_amount_type'] = $getData[$i]['worker_amount_type'];
                    */

                    $returnData['data'][$i]['status'] = $getData[$i]['status'];

                    $returnData['data'][$i]['amount_type'] = $getData[$i]['amount_type'];
                    $returnData['data'][$i]['total_amount'] = $getData[$i]['total_amount'];

                    $returnData['data'][$i]['due_date'] = $getData[$i]['due_date'];

                    $returnData['data'][$i]['amount_receive_status'] = $getData[$i]['amount_receive_status'];
                    $returnData['data'][$i]['amount_receive_transaction'] = $getData[$i]['amount_receive_transaction'];
                    $returnData['data'][$i]['amount_recieve_date'] = $getData[$i]['amount_recieve_date'];
                    $returnData['data'][$i]['amount_commission'] = $getData[$i]['amount_commission'];

                    $image_api_url = Themesettings::select('image_api_url')->where('id', 1)->first();

                    $rentalpropertymanagement_expense_details = RentalPropertyManagementExpenseDetails::where('pro_rentals_property_management_expense_id', $getData[$i]['id'])->get();
                    $returnDetails = array();
                    if (!empty($rentalpropertymanagement_expense_details) && count($rentalpropertymanagement_expense_details)) {
                        for ($j = 0; $j < count($rentalpropertymanagement_expense_details); $j++) {
                            $returnDetails[$j]['id'] = $this->encode($rentalpropertymanagement_expense_details[$j]->id);
                            $returnDetails[$j]['pro_rentals_property_management_expense_id'] = $this->encode($rentalpropertymanagement_expense_details[$j]->pro_rentals_property_management_expense_id);
                            $returnDetails[$j]['expense_management_master_id'] = $this->encode($rentalpropertymanagement_expense_details[$j]->expense_management_master_id);
                            $exp_name = Expensemanagement::where('id',$rentalpropertymanagement_expense_details[$j]->expense_management_master_id)->first();
                            $returnDetails[$j]['expense_service'] = $exp_name->type;
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
                    $returnData['data'][$i]['rentalpropertymanagement_expense_details'] = $returnDetails;

                    $rentalpropertymanagement_worker_details = RentalPropertyManagementExpenseWorkerDetails::where('pro_rentals_property_management_expense_id', $getData[$i]['id'])->get();
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
                    $returnData['data'][$i]['rentalpropertymanagement_worker_details'] = $returnWorkerDetails;

                }
                if ($request->flag != "dashboard") {
                    $returnData['meta']['pagination']['total'] = $getData->total();
                    $returnData['meta']['pagination']['count'] = $getData->count();
                    $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                    $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                    $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                    $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                    $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
                }
            } else {
                $returnData['message'] = "Data Not Found";
                $returnData['object'] = "pro_rentals_property_management_expense";
                if ($request->flag != "dashboard") {
                    $returnData['meta']['pagination']['total'] = $getData->total();
                    $returnData['meta']['pagination']['count'] = $getData->count();
                    $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                    $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                    $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                    $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                    $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
                }
            }
            return $returnData;
        } catch (Exception $e) {
            return $e;
        }
    }
}
