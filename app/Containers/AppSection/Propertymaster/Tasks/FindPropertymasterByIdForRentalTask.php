<?php

namespace App\Containers\AppSection\Propertymaster\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Data\Repositories\PropertymasterRepository;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class FindPropertymasterByIdForRentalTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PropertymasterRepository $repository
    ) {
    }

    public function run($id, $InputData)
    {
        try {
            $current_date = date('Y-m-d');
            $flag = $InputData->getFlag();
            $image_api_url = Themesettings::where('id', 1)->first();
            $getData = Propertymaster::select('pro_property_master.*')
                ->where('id', $id)
                ->first();

            $returnData = array();
            $returnDetails = array();
            $returnShareDetails = array();
            if (!empty($getData)) {
                $returnData['message'] = "Data Found";
                $returnData['data']['object'] = "pro_tenantusers";
                $returnData['data']['id'] = $this->encode($getData['id']);
                $returnData['data']['type_id'] = $this->encode($getData['type_id']);
                $returnData['data']['type'] = $getData['type'];
                $returnData['data']['firm_name'] = $getData['firm_name'];
                $returnData['data']['property_purchase_price'] = $getData['property_purchase_price'];
                $returnData['data']['property_purchase_date'] = $getData['property_purchase_date'];
                $returnData['data']['property_current_market_value'] = $getData['property_current_market_value'];
                $returnData['data']['property_owner'] = $this->encode($getData['property_owner']);
                $returnData['data']['property_owner_id'] = $this->encode($getData['property_owner_id']);
                $returnData['data']['property_owner_commission_amount'] = $getData['property_owner_commission_amount'];
                $returnData['data']['property_owner_commission_percentage'] = $getData['property_owner_commission_percentage'];
                $returnData['data']['property_address_1'] = $getData['property_address_1'];
                $returnData['data']['property_address_2'] = $getData['property_address_2'];
                $returnData['data']['property_city'] = $getData['property_city'];
                $returnData['data']['property_state'] = $getData['property_state'];
                $returnData['data']['property_country'] = $getData['property_country'];
                $returnData['data']['property_zipcode'] = $getData['property_zipcode'];
                $returnData['data']['status'] = $getData['status'];

                // $propertymaster_details = PropertymasterDetails::where('pro_property_master_id', $getData->id)->get();

                $propertymaster_details = PropertymasterDetails::where('pro_property_master_id', $getData->id)->where('property_status', '!=', 0)->get();
                $returnDetails = [];
                if (!empty($propertymaster_details) && count($propertymaster_details)) {
                    $loop = 0;
                    for ($j = 0; $j < count($propertymaster_details); $j++) {

                        if ($flag == "edit") {
                            $pro_property_master_details_id = $this->decode($InputData->getProPropertyMasterDetailsId());
                            if ($pro_property_master_details_id != $propertymaster_details[$j]->id) {
                                $check_unit_assigned = RentalPropertyManagement::select('lease_status')->where('pro_property_master_details_id', $propertymaster_details[$j]->id)->orderBy('created_at', 'DESC')->first();
                            } else {
                                $check_unit_assigned = 0;
                            }
                        } else {
                            $check_unit_assigned = RentalPropertyManagement::select('lease_status')->where('pro_property_master_details_id', $propertymaster_details[$j]->id)->orderBy('created_at', 'DESC')->first();
                        }

                        if (empty($check_unit_assigned)) {
                            $returnDetails[$loop]['id'] = $this->encode($propertymaster_details[$j]->id);
                            $returnDetails[$loop]['pro_property_master_id'] = $this->encode($propertymaster_details[$j]->pro_property_master_id);
                            $returnDetails[$loop]['units_name'] = $propertymaster_details[$j]->units_name;
                            $returnDetails[$loop]['units_beds'] = $propertymaster_details[$j]->units_beds;
                            $returnDetails[$loop]['units_baths'] = $propertymaster_details[$j]->units_baths;
                            $returnDetails[$loop]['units_size'] = $propertymaster_details[$j]->units_size;
                            $returnDetails[$loop]['market_rent'] = $propertymaster_details[$j]->market_rent;
                            $returnDetails[$loop]['property_photo_1'] = ($propertymaster_details[$j]->property_photo_1) ? $image_api_url->image_api_url . $propertymaster_details[$j]->property_photo_1 : "";
                            $returnDetails[$loop]['property_photo_2'] = ($propertymaster_details[$j]->property_photo_2) ? $image_api_url->image_api_url . $propertymaster_details[$j]->property_photo_2 : "";
                            $returnDetails[$loop]['property_photo_3'] = ($propertymaster_details[$j]->property_photo_3) ? $image_api_url->image_api_url . $propertymaster_details[$j]->property_photo_3 : "";
                            $returnDetails[$loop]['property_status'] = $propertymaster_details[$j]->property_status;
                            $loop++;
                        } else {
                            if ($check_unit_assigned->lease_status == 0) {
                                $returnDetails[$loop]['id'] = $this->encode($propertymaster_details[$j]->id);
                                $returnDetails[$loop]['pro_property_master_id'] = $this->encode($propertymaster_details[$j]->pro_property_master_id);
                                $returnDetails[$loop]['units_name'] = $propertymaster_details[$j]->units_name;
                                $returnDetails[$loop]['units_beds'] = $propertymaster_details[$j]->units_beds;
                                $returnDetails[$loop]['units_baths'] = $propertymaster_details[$j]->units_baths;
                                $returnDetails[$loop]['units_size'] = $propertymaster_details[$j]->units_size;
                                $returnDetails[$loop]['market_rent'] = $propertymaster_details[$j]->market_rent;
                                $returnDetails[$loop]['property_photo_1'] = ($propertymaster_details[$j]->property_photo_1) ? $image_api_url->image_api_url . $propertymaster_details[$j]->property_photo_1 : "";
                                $returnDetails[$loop]['property_photo_2'] = ($propertymaster_details[$j]->property_photo_2) ? $image_api_url->image_api_url . $propertymaster_details[$j]->property_photo_2 : "";
                                $returnDetails[$loop]['property_photo_3'] = ($propertymaster_details[$j]->property_photo_3) ? $image_api_url->image_api_url . $propertymaster_details[$j]->property_photo_3 : "";
                                $returnDetails[$loop]['property_status'] = $propertymaster_details[$j]->property_status;
                                $loop++;
                            }
                        }
                    }
                } else {
                    $returnDetails = [];
                }
                $returnData['data']['property_master_details'] = $returnDetails;

                $returnShareDetails = [];
                $propertyshare_details = PropertymasterShareDetails::where('pro_property_master_id', $getData->id)->get();
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
                $returnData['data']['propertyshare_details'] = $returnShareDetails;
            } else {
                $returnData['message'] = "Data Not Found";
                $returnData['object'] = "pro_tenantusers";
            }
            return $returnData;
        } catch (Exception $e) {
            return $e;
        }
    }
}
