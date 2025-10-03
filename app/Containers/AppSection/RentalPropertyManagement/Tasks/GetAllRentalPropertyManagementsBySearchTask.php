<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\RentalPropertyManagement\Data\Repositories\RentalPropertyManagementRepository;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagementLateFees;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalPropertyManagementsBySearchTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RentalPropertyManagementRepository $repository
    ) {
    }


    public function run($InputData)
    {


        try {
            $current_date = date('Y-m-d');
            $image_api_url = Themesettings::where('id', 1)->first();
            $per_page = (int) $InputData->getPerPage();
            $field_db = $InputData->getFieldDB();
            $search_val = $InputData->getSearchVal();
            if (($field_db == "") || ($field_db == NULL)) {
                $getData = RentalPropertyManagement::orderBy('pro_rentals_property_management.created_at', 'DESC')->paginate($per_page);
            } else {
                if ($field_db == "property_master_id" || $field_db == "pro_property_master_details_id" || $field_db == "user_id") {
                    if ($field_db == "id") {
                        $field_db = "pro_rentals_property_management.id";
                    }
                    $search_val = $this->decode($search_val);
                }

                $getData = RentalPropertyManagement::select('pro_rentals_property_management.*')
                    ->where($field_db, 'like', '%' . $search_val . '%')
                    ->orderBy('pro_rentals_property_management.created_at', 'DESC')
                    ->paginate($per_page);
            }
            $returnData = array();
            $returnDetails = array();
            //   $returnShareDetails = array();
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    ($getData[$i]->image) ? $image_api_url->image_api_url . $getData[$i]->image : "";
                    $returnData['data'][$i]['object'] = "pro_rentals_property_management";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                    $returnData['data'][$i]['property_master_id'] = $this->encode($getData[$i]['property_master_id']);
                    $property_name = Propertymaster::find($getData[$i]['property_master_id'])->property_name;
                    $returnData['data'][$i]['property_name'] = $property_name;
                    $returnData['data'][$i]['pro_property_master_details_id'] = $this->encode($getData[$i]['pro_property_master_details_id']);
                    $unit_name = PropertymasterDetails::find($getData[$i]['pro_property_master_details_id'])->units_name;
                    $returnData['data'][$i]['unit_name'] = $unit_name ?? "";
                    $returnData['data'][$i]['lease_start_date'] = date('m-d-Y', strtotime($getData[$i]['lease_start_date']));
                    $returnData['data'][$i]['lease_end_date'] = date('m-d-Y', strtotime($getData[$i]['lease_end_date']));

                    $returnData['data'][$i]['lease_status'] = $getData[$i]['lease_status'];

                    $returnData['data'][$i]['user_id'] = $this->encode($getData[$i]['user_id']);
                    $tenant_name = Tenantusers::find($getData[$i]['user_id'])->first_name;
                    $returnData['data'][$i]['tenant_name'] = $tenant_name;
                    $returnData['data'][$i]['rent_date'] = $getData[$i]['rent_date'];
                    $returnData['data'][$i]['rent_frequency'] = $getData[$i]['rent_frequency'];
                    $returnData['data'][$i]['rent_amount'] = $getData[$i]['rent_amount'];
                    $returnData['data'][$i]['security_deposit'] = $getData[$i]['security_deposit'];
                    $returnData['data'][$i]['advance_amount'] = $getData[$i]['advance_amount'];
                    $returnData['data'][$i]['late_fees'] = $getData[$i]['late_fees'];
                    $returnData['data'][$i]['lease_document'] = ($getData[$i]->lease_document) ? $image_api_url->image_api_url . $getData[$i]->lease_document : "";
                    $image_api_url = Themesettings::select('image_api_url')->where('id', 1)->first();

                    $rentalpropertymanagement_late_fees = RentalPropertyManagementLateFees::where('pro_rentals_property_management_id', $getData[$i]['id'])->get();
                    $returnDetails = array();
                    if (!empty($rentalpropertymanagement_late_fees) && count($rentalpropertymanagement_late_fees)) {
                        for ($j = 0; $j < count($rentalpropertymanagement_late_fees); $j++) {
                            $returnDetails[$j]['id'] = $this->encode($rentalpropertymanagement_late_fees[$j]->id);
                            $returnDetails[$j]['pro_rentals_property_management_id'] = $this->encode($rentalpropertymanagement_late_fees[$j]->pro_rentals_property_management_id);
                            $returnDetails[$j]['date_range_type'] = $rentalpropertymanagement_late_fees[$j]->date_range_type;
                            $returnDetails[$j]['date_range_value'] = $rentalpropertymanagement_late_fees[$j]->date_range_value;
                            $returnDetails[$j]['late_fees_amount'] = $rentalpropertymanagement_late_fees[$j]->late_fees_amount;
                        }
                    } else {
                        $returnDetails = [];
                    }
                    $returnData['data'][$i]['rentalpropertymanagement_late_fees'] = $returnDetails;
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
                $returnData['object'] = "pro_rentals_property_management";
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
