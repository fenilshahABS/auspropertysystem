<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\RentalPropertyManagement\Data\Repositories\RentalPropertyManagementRepository;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagementLateFees;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalPropertyManagementsTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RentalPropertyManagementRepository $repository
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
            $current_date = date('Y-m-d');
            if ($request->flag != "reports") {

                $getData = RentalPropertyManagement::select('pro_rentals_property_management.*')
                    ->where('lease_status', 1)
                    ->orderBy('pro_rentals_property_management.created_at', 'DESC')
                    ->get();

                $returnData = array();
                $returnDetails = array();

                if (!empty($getData) && count($getData) >= 1) {
                    $returnData['message'] = "Data Found";
                    for ($i = 0; $i < count($getData); $i++) {
                        ($getData[$i]->image) ? $image_api_url->image_api_url . $getData[$i]->image : "";
                        $returnData['data'][$i]['object'] = "pro_rentals_property_management";
                        $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                        $returnData['data'][$i]['property_master_id'] = $this->encode($getData[$i]['property_master_id']);
                        $returnData['data'][$i]['pro_property_master_details_id'] = $this->encode($getData[$i]['pro_property_master_details_id']);


                        $property_name = Propertymaster::select('property_name', 'firm_name','type','property_address_1','property_address_2','property_city','property_state','property_country','property_zipcode')->where('id', $getData[$i]['property_master_id'])->first();
                        $returnData['data'][$i]['firm_name'] = $property_name->firm_name ?? "";
                        $returnData['data'][$i]['name'] = $property_name->property_name ?? "";
                        $returnData['data'][$i]['type'] = $property_name->type ?? "";
                        $address = "";
                        if(!empty($property_name)){
                          $address = $property_name->property_address_1." ".$property_name->property_address_2;
                        }
                        $returnData['data'][$i]['address'] =  $address;
                        $returnData['data'][$i]['city'] = $property_name->property_city ?? "";
                        $returnData['data'][$i]['state'] = $property_name->property_state ?? "";
                        $returnData['data'][$i]['country'] = $property_name->property_country ?? "";
                        $returnData['data'][$i]['zipcode'] = $property_name->property_zipcode ?? "";

                        $property_unit_name = PropertymasterDetails::select('units_name')->where('id', $getData[$i]['pro_property_master_details_id'])->first();


                        $returnData['data'][$i]['property_name'] = $property_name->property_name ?? "";
                        $returnData['data'][$i]['property_unit_name'] = $property_unit_name->units_name ?? "";
                        // $unit_name = PropertymasterDetails::find($getData[$i]['pro_property_master_details_id'])->units_name;
                        // $returnData['data'][$i]['unit_name'] = $unit_name ?? "";
                        $returnData['data'][$i]['lease_start_date'] = $getData[$i]['lease_start_date'];
                        $returnData['data'][$i]['lease_end_date'] = $getData[$i]['lease_end_date'];
                        $returnData['data'][$i]['user_id'] = $this->encode($getData[$i]['user_id']);
                        // $tenant_name = Tenantusers::find($getData[$i]['user_id'])->first_name;
                        // $returnData['data'][$i]['tenant_name'] = $tenant_name;
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
                } else {
                    $returnData['message'] = "Data Not Found";
                    $returnData['object'] = "pro_rentals_property_management";
                }
            } else {

                /*
                $getData = RentalPropertyManagement::distinct('property_master_id')->where('lease_status', 1)
                    ->get();
                if (!empty($getData) && count($getData) >= 1) {
                    $returnData['message'] = "Data Found";
                    for ($i = 0; $i < count($getData); $i++) {
                        $returnData['data'][$i]['object'] = "pro_rentals_property_management";
                        $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                        $returnData['data'][$i]['property_master_id'] = $this->encode($getData[$i]['property_master_id']);
                        $returnData['data'][$i]['pro_property_master_details_id'] = $this->encode($getData[$i]['pro_property_master_details_id']);
                    }
                }
                */

                    $property_id = RentalPropertyManagement::where('lease_status', 1)
                        ->distinct('property_master_id')
                        ->pluck('property_master_id')
                        ->toArray();
                    $property_master = Propertymaster::whereIn('id', $property_id)->get();
                    if (!empty($property_master)) {
                        for ($i = 0; $i < count($property_master); $i++) {
                            $returnData['data'][$i]['object'] = "pro_rentals_property_management";
                            $returnData['data'][$i]['property_master_id'] = $this->encode($property_master[$i]['id']);
                            $returnData['data'][$i]['property_name'] = $property_master[$i]['property_name'];

                            $returnData['data'][$i]['firm_name'] = $property_master[$i]['firm_name'];
                            $returnData['data'][$i]['name'] = $property_master[$i]['property_name'];
                            $returnData['data'][$i]['type'] = $property_master[$i]['type'];
                            $address = "";
                            $address = $property_master[$i]['property_address_1']." ".$property_master[$i]['property_address_2'];
                            $returnData['data'][$i]['address'] =  $address;
                            $returnData['data'][$i]['city'] = $property_master[$i]['property_city'];
                            $returnData['data'][$i]['state'] = $property_master[$i]['property_state'];
                            $returnData['data'][$i]['country'] = $property_master[$i]['property_country'];
                            $returnData['data'][$i]['zipcode'] = $property_master[$i]['property_zipcode'];

                        }
                    } else {
                        $returnData['message'] = "Data Not Found";
                    }
            }
            return $returnData;
        } catch (Exception $e) {
            return $e;
        }
    }
}
