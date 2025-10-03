<?php

namespace App\Containers\AppSection\Propertymaster\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Data\Repositories\PropertymasterRepository;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllPropertymastersApplicationTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PropertymasterRepository $repository
    ) {
    }

    public function run($InputData)
    {
        try {
            $getLoginUser = Auth::user();
            $returnData = array();
            $image_api_url = Themesettings::where('id', 1)->first();
            $per_page = (int) $InputData->getPerPage();
            $field_db = $InputData->getFieldDB();
            $search_val = $InputData->getSearchVal();
            $property_share = PropertymasterShareDetails::where('property_owner_id', $getLoginUser->id)
                ->pluck('pro_property_master_id')
                ->unique()
                ->toArray();

            if (!empty($property_share) && count($property_share) >= 1) {
                if (($field_db == "") || ($field_db == NULL)) {
                    $getData = Propertymaster::whereIn('id', $property_share)->paginate($per_page);
                } else {
                    if ($field_db == "pro_property_master_id" || $field_db == "property_owner_id" || $field_db == "id") {
                        if ($field_db == "id") {
                            $field_db = "pro_property_master.id";
                        }
                        $search_val = $this->decode($search_val);
                    }
                    $getData = Propertymaster::whereIn('id', $property_share)->where($field_db, 'like', '%' . $search_val . '%')->paginate($per_page);
                }
            } else {
                $returnData['message'] = "No Data Found";
                $returnData['data'] = [];
                return $returnData;
            }


            $returnDetails = array();
            $returnShareDetails = array();
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {

                    $returnData['data'][$i]['object'] = "pro_tenantusers";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                    $returnData['data'][$i]['type_id'] = $this->encode($getData[$i]['type_id']);
                    $returnData['data'][$i]['type'] = $getData[$i]['type'];
                    $returnData['data'][$i]['property_name'] = $getData[$i]['property_name'];
                    $returnData['data'][$i]['firm_name'] = $getData[$i]['firm_name'];
                    $returnData['data'][$i]['property_purchase_price'] = $getData[$i]['property_purchase_price'];
                    $returnData['data'][$i]['property_purchase_date'] = $getData[$i]['property_purchase_date'];
                    $returnData['data'][$i]['property_current_market_value'] = $getData[$i]['property_current_market_value'];
                    $returnData['data'][$i]['property_owner'] = $getData[$i]['property_owner'];
                    $returnData['data'][$i]['property_owner_id'] = $this->encode($getData[$i]['property_owner_id']);
                    $returnData['data'][$i]['property_owner_commission_amount'] = $getData[$i]['property_owner_commission_amount'];
                    $returnData['data'][$i]['property_owner_commission_percentage'] = $getData[$i]['property_owner_commission_percentage'];
                    $returnData['data'][$i]['property_address_1'] = $getData[$i]['property_address_1'];
                    $returnData['data'][$i]['property_address_2'] = $getData[$i]['property_address_2'];
                    $returnData['data'][$i]['property_city'] = $getData[$i]['property_city'];
                    $returnData['data'][$i]['property_state'] = $getData[$i]['property_state'];
                    $returnData['data'][$i]['property_country'] = $getData[$i]['property_country'];
                    $returnData['data'][$i]['property_zipcode'] = $getData[$i]['property_zipcode'];
                    $returnData['data'][$i]['status'] = $getData[$i]['status'];


                    $propertymaster_details = PropertymasterDetails::where('pro_property_master_id', $getData[$i]->id)->get();
                    $returnDetails = [];
                    if (!empty($propertymaster_details) && count($propertymaster_details)) {
                        for ($j = 0; $j < count($propertymaster_details); $j++) {
                            $returnDetails[$j]['id'] = $this->encode($propertymaster_details[$j]->id);
                            $returnDetails[$j]['pro_property_master_id'] = $this->encode($propertymaster_details[$j]->pro_property_master_id);
                            $returnDetails[$j]['units_name'] = $propertymaster_details[$j]->units_name;
                            $returnDetails[$j]['units_beds'] = $propertymaster_details[$j]->units_beds;
                            $returnDetails[$j]['units_baths'] = $propertymaster_details[$j]->units_baths;
                            $returnDetails[$j]['units_size'] = $propertymaster_details[$j]->units_size;
                            $returnDetails[$j]['market_rent'] = $propertymaster_details[$j]->market_rent;
                            $returnDetails[$j]['property_photo_1'] = ($propertymaster_details[$j]->property_photo_1) ? $image_api_url->image_api_url . $propertymaster_details[$j]->property_photo_1 : "";
                            $returnDetails[$j]['property_photo_2'] = ($propertymaster_details[$j]->property_photo_2) ? $image_api_url->image_api_url . $propertymaster_details[$j]->property_photo_2 : "";
                            $returnDetails[$j]['property_photo_3'] = ($propertymaster_details[$j]->property_photo_3) ? $image_api_url->image_api_url . $propertymaster_details[$j]->property_photo_3 : "";
                            $returnDetails[$j]['property_status'] = $propertymaster_details[$j]->property_status;
                        }
                    } else {
                        $returnDetails = [];
                    }
                    $returnData['data'][$i]['propertymaster_details'] = $returnDetails;

                    $returnShareDetails = [];
                    $propertyshare_details = PropertymasterShareDetails::where('pro_property_master_id', $getData[$i]->id)->get();
                    if (!empty($propertyshare_details) && count($propertyshare_details)) {
                        for ($k = 0; $k < count($propertyshare_details); $k++) {
                            $returnShareDetails[$k]['id'] = $this->encode($propertyshare_details[$k]->id);
                            $returnShareDetails[$k]['pro_property_master_id'] = $this->encode($propertyshare_details[$k]->pro_property_master_id);
                            $returnShareDetails[$k]['property_owner_id'] = $this->encode($propertyshare_details[$k]->property_owner_id);
                            $returnShareDetails[$k]['ownership_share'] = $propertyshare_details[$k]->ownership_share;
                        }
                    } else {
                        $returnShareDetails = [];
                    }
                    $returnData['data'][$i]['propertyshare_details'] = $returnShareDetails;
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
                $returnData['object'] = "pro_tenantusers";
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
