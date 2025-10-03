<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
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

class GetAllRentalPropertyManagementExpensesByWorkerIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RentalPropertyManagementExpenseRepository $repository
    ) {
    }


    public function run($InputData)
    {
        try {

            $company_details = Themesettings::where('id', 1)->first();
            $per_page = (int) $InputData->getPerPage();
            $field_db = $InputData->getFieldDB();
            $search_val = $InputData->getSearchVal();
            $worker_id = $this->decode($InputData->getWorkerId());
            $start_date = $InputData->getFromDate()." 00:00:00";
            $end_date = $InputData->getToDate()." 23:59:59";
            $amount_paid_status = $InputData->getWorkerAmountPaidStatus();

            $query = RentalPropertyManagementExpenseWorkerDetails::select('pro_rentals_property_management_expense_worker_details.*','property_owner.first_name as property_owner_name','pro_rentals_property_management_expense.pro_rentals_property_management_id')
            ->leftjoin('pro_rentals_property_management_expense', 'pro_rentals_property_management_expense.id', 'pro_rentals_property_management_expense_worker_details.pro_rentals_property_management_expense_id')
            ->leftjoin('pro_rentals_property_management', 'pro_rentals_property_management.id', 'pro_rentals_property_management_expense.pro_rentals_property_management_id')
            ->leftjoin('pro_property_master', 'pro_property_master.id', 'pro_rentals_property_management.property_master_id')
            ->leftjoin('pro_property_master_share_details', 'pro_property_master_share_details.pro_property_master_id', 'pro_rentals_property_management.property_master_id')
            ->leftjoin('pro_tenantusers as property_owner', 'property_owner.id', 'pro_property_master_share_details.property_owner_id');

            if (!empty($worker_id)) {
                $query->where('pro_rentals_property_management_expense_worker_details.worker_id', $worker_id);
            }
            if(!empty($amount_paid_status)){
            //if($amount_paid_status>=0){
              $query->where('pro_rentals_property_management_expense_worker_details.worker_amount_paid_status', $amount_paid_status);
            }
            $query->whereBetween('pro_rentals_property_management_expense_worker_details.created_at', [$start_date,$end_date]);
            $getData = $query->orderBy('pro_rentals_property_management_expense_worker_details.created_at', 'DESC')->paginate($per_page);

            $returnData = array();
            $returnDetails = array();
            //   $returnShareDetails = array();
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['object'] = "pro_rentals_property_management_worker";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                    $returnData['data'][$i]['pro_rentals_property_management_expense_id'] = $this->encode($getData[$i]['pro_rentals_property_management_expense_id']);

                    $property_master_data  = RentalPropertyManagement::select('property_master_id', 'pro_property_master_details_id')->where('id', $getData[$i]['pro_rentals_property_management_id'])->first();
                    if (!empty($property_master_data)) {
                        $property_name = Propertymaster::select('property_name')->where('id', $property_master_data->property_master_id)->first();
                    }
                    if (!empty($property_master_data)) {
                        $property_unit_name = PropertymasterDetails::select('units_name')->where('id', $property_master_data->pro_property_master_details_id)->first();
                    }

                    $returnData['data'][$i]['property_name'] = $property_name->property_name ?? "";
                    $returnData['data'][$i]['property_owner_name'] = $getData[$i]->property_owner_name ?? "";
                    $returnData['data'][$i]['property_unit_name'] = $property_unit_name->units_name ?? "";

                    $returnData['data'][$i]['worker_name'] = NULL;
                    $returnData['data'][$i]['worker_email'] = NULL;
                    $returnData['data'][$i]['worker_mobile_no'] = NULL;
                    $workerData = Workermaster::where('id',$getData[$i]->worker_id)->first();
                    if(!empty($workerData)){
                      $returnData['data'][$i]['worker_name'] = $workerData->worker_name;
                      $returnData['data'][$i]['worker_email'] = $workerData->worker_email;
                      $returnData['data'][$i]['worker_mobile_no'] = $workerData->worker_mobile_no;
                    }

                    $returnData['data'][$i]['worker_amount'] = $getData[$i]['worker_amount'];
                    $returnData['data'][$i]['worker_amount_paid_status'] = $getData[$i]['worker_amount_paid_status'];
                    $returnData['data'][$i]['worker_amount_paid_transaction'] = $getData[$i]['worker_amount_paid_transaction'];
                    $returnData['data'][$i]['worker_amount_paid_date'] = $getData[$i]['worker_amount_paid_date'];
                    $returnData['data'][$i]['worker_notes'] = $getData[$i]['worker_notes'];
                    $returnData['data'][$i]['worker_amount_type'] = $getData[$i]['worker_amount_type'];

                }

                $returnData['meta']['pagination']['total'] = $getData->total();
                $returnData['meta']['pagination']['count'] = $getData->count();
                $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            } else {
                $returnData['message'] = "Data Not Found";
                $returnData['object'] = "pro_rentals_property_management_expense";
                $returnData['meta']['pagination']['total'] = $getData->total();
                $returnData['meta']['pagination']['count'] = $getData->count();
                $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            }
            return $returnData;
        } catch (Exception $e) {
            return $e;
        }
    }
}
