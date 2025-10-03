<?php

namespace App\Containers\AppSection\Dashboard\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Dashboard\Data\Repositories\DashboardRepository;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;

class PartnerClientDashboardTask extends ParentTask
{
    public function __construct(
        protected DashboardRepository $repository
    ) {
    }

    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run($id)
    {
        $returnData = array();

        $property_count = PropertymasterShareDetails::where('property_owner_id', $id)->distinct('pro_property_master_id')->count();
        $returnData['data'][0]['icon'] = "business";
        $returnData['data'][0]['label'] = "Properties";
        $returnData['data'][0]['count'] = $property_count;
        $property_id = PropertymasterShareDetails::where('property_owner_id', $id)->distinct('pro_property_master_id')->pluck('pro_property_master_id')->toArray();


        $unit_count = PropertymasterDetails::whereIn('pro_property_master_id', $property_id)->count();
        $returnData['data'][1]['icon'] = "key";
        $returnData['data'][1]['label'] = "Units";
        $returnData['data'][1]['count'] = $unit_count;
        // $rental_property_count = PropertymasterDetails::whereIn('pro_property_master_id', $property_id)->where('property_status', 2)->count();
        // $returnData['data'][0]['rental_property_count'] = $rental_property_count;

        // $maintenance_property_count = PropertymasterDetails::whereIn('pro_property_master_id', $property_id)->where('property_status', 9)->count();
        // $returnData['data'][0]['maintenance_property_count'] = $maintenance_property_count;

        $returnData['message'] = "Partner / Client Dashboards Count";

        return $returnData;
    }
}
