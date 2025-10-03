<?php

namespace App\Containers\AppSection\Propertymaster\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Data\Repositories\PropertymasterRepository;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\Rolemaster\Models\Rolemaster;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllPropertymastersRentalTask extends ParentTask
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
    public function run($request)
    {
        try {
            $image_api_url = Themesettings::where('id', 1)->first();
            $getData = Propertymaster::select('pro_property_master.*')
                ->orderBy('pro_property_master.created_at', 'DESC')
                ->get();
            $editable_row_id = $this->decode($request->property_master_id);
            $current_date = date('Y-m-d');
            $returnData['data'] = array();
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {

                    $property_master_details_data = PropertymasterDetails::where('pro_property_master_id', $getData[$i]->id)->pluck('id')->toArray();
                    if (!empty($property_master_details_data) && count($property_master_details_data) >= 1) {
                        for ($k = 0; $k < count($property_master_details_data); $k++) {
                            // $check_data_in_rental_property = RentalPropertyManagement::where('pro_property_master_details_id', $property_master_details_data[$k])->whereDate('lease_end_date', '<=', $current_date)->count();
                            $check_data_in_rental_property = RentalPropertyManagement::select('lease_status')->where('pro_property_master_details_id', $property_master_details_data[$k])->orderBy('created_at', 'DESC')->first();
                            if (empty($check_data_in_rental_property) || ($getData[$i]->id == $editable_row_id)) {
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
                                break;
                            } else {
                                if ($check_data_in_rental_property->lease_status == 0) {
                                    $returnData['data'][$i]['object'] = "pro_tenantusers";
                                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                                    $returnData['data'][$i]['type_id'] = $this->encode($getData[$i]['type_id']);
                                    $returnData['data'][$i]['type'] = $getData[$i]['type'];
                                    $returnData['data'][$i]['property_name'] = $getData[$i]['property_name'];
                                    $returnData['data'][$i]['firm_name'] = $getData[$i]['firm_name'];
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
                                    break;
                                }
                            }
                        }
                    }
                }
                $returnData['data'] = array_values($returnData['data']);
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
