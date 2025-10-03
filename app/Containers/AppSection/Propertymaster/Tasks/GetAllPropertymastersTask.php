<?php

namespace App\Containers\AppSection\Propertymaster\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Data\Repositories\PropertymasterRepository;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Containers\AppSection\Rolemaster\Models\Rolemaster;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllPropertymastersTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PropertymasterRepository $repository
    ) {
    }

    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(): mixed
    {
        try {
            $image_api_url = Themesettings::where('id', 1)->first();
            $getData = Propertymaster::select('pro_property_master.*')
                ->orderBy('pro_property_master.created_at', 'DESC')
                ->get();

            $returnData = array();
            $returnDetails = array();
            $returnShareDetails = array();
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {

                    $returnData['data'][$i]['object'] = "pro_property_master";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                    $returnData['data'][$i]['type_id'] = $this->encode($getData[$i]['type_id']);
                    $returnData['data'][$i]['type'] = $getData[$i]['type'];
                    $returnData['data'][$i]['property_name'] = $getData[$i]['property_name'];
                    $returnData['data'][$i]['firm_name'] = $getData[$i]['firm_name'];
                    $returnData['data'][$i]['property_purchase_price'] = $getData[$i]['property_purchase_price'];
                    $returnData['data'][$i]['property_purchase_date'] = $getData[$i]['property_purchase_date'];
                    $returnData['data'][$i]['property_current_market_value'] = $getData[$i]['property_current_market_value'];
                    $returnData['data'][$i]['property_owner'] = $getData[$i]['property_owner'];
                    $role_name = Rolemaster::find($getData[$i]['property_owner'])->name;
                    $returnData['data'][$i]['property_owner_role'] = $role_name ?? "";
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
                            $returnShareDetails[$k]['property_owner_id'] = $propertyshare_details[$k]->property_owner_id;
                            $returnShareDetails[$k]['ownership_share'] = $propertyshare_details[$k]->ownership_share;
                        }
                    } else {
                        $returnShareDetails = [];
                    }
                    $returnData['data'][$i]['propertyshare_details'] = $returnShareDetails;
                }
            } else {
                $returnData['message'] = "Data Not Found";
                $returnData['object'] = "pro_property_master";
            }
            return $returnData;
        } catch (Exception $e) {
            return $e;
        }
    }
}
