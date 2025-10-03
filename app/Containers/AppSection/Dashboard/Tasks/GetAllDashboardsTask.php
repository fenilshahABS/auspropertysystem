<?php

namespace App\Containers\AppSection\Dashboard\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Dashboard\Data\Repositories\DashboardRepository;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
//use App\Containers\AppSection\Tenantusers\Models\PropertymasterDetails;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllDashboardsTask extends ParentTask
{
    public function __construct(
        protected DashboardRepository $repository
    ) {
    }

    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run()
    {
        $returnData = array();

        $client_count = Tenantusers::where('role_id', 2)->count();
        $returnData['data'][0]['client_count'] = $client_count;

        $partner_count = Tenantusers::where('role_id', 3)->count();
        $returnData['data'][0]['partner_count'] = $partner_count;

        $tenant_count = Tenantusers::where('role_id', 4)->count();
        $returnData['data'][0]['tenant_count'] = $tenant_count;

        $rental_invoice_paid_count = RentalInvoice::where('status', 1)->count();
        $returnData['data'][0]['rental_invoice_paid_count'] = $rental_invoice_paid_count;

        $rental_invoice_pending_count = RentalInvoice::where('status', 0)->count();
        $returnData['data'][0]['rental_invoice_pending_count'] = $rental_invoice_pending_count;

        $rental_property_count = PropertymasterDetails::where('property_status', 2)->count();
        $returnData['data'][0]['rental_property_count'] = $rental_property_count;

        $maintenance_management_pending_count = RentalPropertyManagementExpense::where('amount_receive_status', 0)->count();
        $returnData['data'][0]['maintenance_management_pending_count'] = $maintenance_management_pending_count;

        $maintenance_management_paid_count = RentalPropertyManagementExpense::where('amount_receive_status', 1)->count();
        $returnData['data'][0]['maintenance_management_paid_count'] = $maintenance_management_paid_count;

        $ongoing_task_count = TaskManagement::where('status', 0)->count();
        $returnData['data'][0]['ongoing_task_count'] = $ongoing_task_count;

        $total_property = Propertymaster::count();
        $returnData['data'][0]['total_property'] = $total_property;

        $total_property_details = PropertymasterDetails::count();
        $returnData['data'][0]['total_property_units'] = $total_property_details;

        $returnData['message'] = "Admin Dashboards Count";
        return $returnData;
    }
}
