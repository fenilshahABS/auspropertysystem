<?php

namespace App\Containers\AppSection\Propertyreports\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\Propertyreports\Data\Repositories\PropertyreportsRepository;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;
use stdClass;

class GetAllPropertyreportsTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PropertyreportsRepository $repository
    ) {
    }


    public function run($InputData)
    {
        //  try {
        $status = $InputData->getStatus();


        $query = PropertymasterDetails::select(
            'pro_property_master.property_name',
            'pro_property_master_details.pro_property_master_id as property_id',
            'pro_property_master.firm_name',
            'pro_property_master_details.id as property_unit_id',
            'pro_property_master_details.units_name',
            // 'pro_tenantusers.email',
            // 'pro_tenantusers.mobile'
        )
            ->leftJoin('pro_property_master', 'pro_property_master.id', 'pro_property_master_details.pro_property_master_id');
        //   ->leftJoin('pro_property_master_share_details', 'pro_property_master_share_details.pro_property_master_id', 'pro_property_master_details.pro_property_master_id');
        //  ->leftJoin('pro_tenantusers', 'pro_tenantusers.id', 'pro_property_master_share_details.property_owner_id')
        // ->where('pro_tenantusers.role_id', '!=', 4);

        if ($status != "") {
            if ($status == 0) {

                //inactive
                $query->where('pro_property_master_details.property_status', 0);
            } elseif ($status == 1) {

                // active
                $query->where('pro_property_master_details.property_status', 1);
            } elseif ($status == 2) {

                // rental
                $query->where('pro_property_master_details.property_status', 2);
            } elseif ($status == 9) {

                // maintenance
                $query->where('pro_property_master_details.property_status', 9);
            }
        }

        $getData = $query->get();
        // $query = Tenantusers::select(
        //     'pro_tenantusers.*',
        //     'pro_property_master.id as property_id',
        //     'pro_property_master.property_name',
        //     'pro_property_master.firm_name',
        //     'pro_property_master_details.id as property_unit_id',
        //     'pro_property_master_details.units_name'
        // )
        //     ->leftJoin('pro_property_master_share_details', 'pro_property_master_share_details.property_owner_id', 'pro_tenantusers.id')
        //     ->leftJoin('pro_property_master', 'pro_property_master.id', 'pro_property_master_share_details.pro_property_master_id')
        //     ->leftJoin('pro_property_master_details', 'pro_property_master_details.pro_property_master_id', 'pro_property_master_share_details.pro_property_master_id')

        //     ->where('pro_tenantusers.role_id', '!=', 4);
        // if ($status != "") {
        //     if ($status == 0) {

        //         //inactive
        //         $query->where('pro_property_master_details.property_status', 0);
        //     } elseif ($status == 1) {

        //         // active
        //         $query->where('pro_property_master_details.property_status', 1);
        //     } elseif ($status == 2) {

        //         // rental
        //         $query->where('pro_property_master_details.property_status', 2);
        //     } elseif ($status == 9) {

        //         // maintenance
        //         $query->where('pro_property_master_details.property_status', 9);
        //     }
        // }

        // $getData = $query->get();

        if (!empty($getData) && count($getData) >= 1) {
            $returnData['message'] = "Data Found";
            for ($i = 0; $i < count($getData); $i++) {
                // $returnData['data'][$i]['object'] = "pro_tenantusers";
                // $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                // $returnData['data'][$i]['role_id'] = $this->encode($getData[$i]['role_id']);
                // $returnData['data'][$i]['first_name'] = $getData[$i]['first_name'];
                // $returnData['data'][$i]['last_name'] = $getData[$i]['last_name'];
                // $returnData['data'][$i]['dob'] = $getData[$i]['dob'];
                // $returnData['data'][$i]['gender'] = $getData[$i]['gender'];
                // $returnData['data'][$i]['email'] = $getData[$i]['email'];
                // $returnData['data'][$i]['mobile'] = $getData[$i]['mobile'];
                // $returnData['data'][$i]['address'] = $getData[$i]['address'];
                // $returnData['data'][$i]['country'] = $getData[$i]['country'];
                // $returnData['data'][$i]['state'] = $getData[$i]['state'];
                // $returnData['data'][$i]['city'] = $getData[$i]['city'];

                $returnData['data'][$i]['property_id'] = $getData[$i]['property_id'];
                $returnData['data'][$i]['property_name'] = $getData[$i]['property_name'];
                $returnData['data'][$i]['firm_name'] = $getData[$i]['firm_name'];

                $returnData['data'][$i]['property_unit_id'] = $getData[$i]['property_unit_id'];
                $returnData['data'][$i]['units_name'] = $getData[$i]['units_name'];

                $rentalData = RentalPropertyManagement::where('property_master_id', $getData[$i]['property_id'])
                    ->where('pro_property_master_details_id', $getData[$i]['property_unit_id'])
                    ->latest('created_at')
                    ->first();
                if (!empty($rentalData)) {
                    $returnData['data'][$i]['lease_start_date'] = $rentalData->lease_start_date;
                    $returnData['data'][$i]['lease_end_date'] = $rentalData->lease_end_date;
                    $tenant = Tenantusers::select(
                        'first_name',
                        'last_name',
                        'email',
                        'mobile'
                    )->where('id', $rentalData->user_id)->first();
                    $returnData['data'][$i]['email'] = $tenant->email ?? "";
                    $returnData['data'][$i]['mobile'] = $tenant->mobile ?? "";
                    $returnData['data'][$i]['tenant_name'] = ($tenant->first_name . ' ' . $tenant->last_name) ?? "";
                    $returnData['data'][$i]['security_deposit'] =  $rentalData->security_deposit;
                    $returnData['data'][$i]['advance_amount'] =  $rentalData->advance_amount;
                } else {
                    $returnData['data'][$i]['lease_start_date'] = "";
                    $returnData['data'][$i]['lease_end_date'] = "";
                    $returnData['data'][$i]['tenant_name'] = "";
                    $returnData['data'][$i]['email'] = "";
                    $returnData['data'][$i]['mobile'] =  "";
                    $returnData['data'][$i]['security_deposit'] =  "";
                    $returnData['data'][$i]['advance_amount'] =  "";
                }
            }
        } else {
            $returnData['message'] = "Data Not Found";
            $returnData['object'] = "pro_tenantusers";
        }
        return $returnData;
        // } catch (Exception $exception) {
        //     throw new NotFoundException();
        // }
    }
}
