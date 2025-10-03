<?php

namespace App\Containers\AppSection\RentalInvoice\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Containers\AppSection\RentalInvoice\Data\Repositories\RentalInvoiceRepository;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Models\RentalOwnerShareInvoice;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;

class PropertyOwnerInvoicesTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RentalInvoiceRepository $repository
    ) {
    }

    public function run($InputData)
    {
        try {
            $returnData = array();
            $user_id = $this->decode($InputData->getUserId());
            $company_details = Themesettings::where('id', 1)->first();
            $property_master_id = $this->decode($InputData->getPropertyMasterId());
            $property_master_details_id = $this->decode($InputData->getPropertyMasterDetailsId());
            $status = $InputData->getStatus();

            $from = $InputData->getFrom();
            $to = $InputData->getTo();
            $per_page = $InputData->getPerPage();
            $user_id = $this->decode($InputData->getUserId());

            $propertyMasterId = PropertymasterShareDetails::select('pro_property_master_id')
                ->where('property_owner_id', $user_id)
                ->distinct()
                ->pluck('pro_property_master_id') // Use pluck to extract property IDs
                ->toArray();

            $query = RentalInvoiceManual::select(
                'pro_rentals_invoice_manual.*',
                'tenant_user.first_name as tenant_name'
            )
                ->leftJoin('pro_rentals_property_management', 'pro_rentals_property_management.id', 'pro_rentals_invoice_manual.rent_id')
                ->leftJoin('pro_tenantusers as tenant_user', 'tenant_user.id', 'pro_rentals_property_management.user_id');

            if (!empty($propertyMasterId)) {
                $query->whereIn('pro_rentals_invoice_manual.property_id', $propertyMasterId);
            }
            if (!empty($property_master_details_id)) {
                $query->where('pro_rentals_invoice_manual.property_unit_id', $property_master_details_id);
            }
            if ($status != "") {
                $query->where('pro_rentals_invoice_manual.status', $status);
            }

            if (!empty($from) && !empty($to)) {
                $query->where('pro_rentals_invoice_manual.invoice_date_gen', '>=', $from);
                $query->where('pro_rentals_invoice_manual.invoice_date_gen', '<=', $to);
            }

            $getData = $query->orderBy('pro_rentals_invoice_manual.id', 'DESC')->paginate($per_page);

            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                    $returnData['data'][$i]['invoice_number'] = $getData[$i]['invoice_number'];
                    $returnData['data'][$i]['rent_id'] = $this->encode($getData[$i]['rent_id']);
                    //      $dueDate = RentalPropertyManagement::where('rent_date')
                    $returnData['data'][$i]['tenant_name'] = $getData[$i]['tenant_name'];
                    $returnData['data'][$i]['firm_name'] = $getData[$i]['firm_name'];
                    $returnData['data'][$i]['property_id'] = $this->encode($getData[$i]['property_id']);
                    $returnData['data'][$i]['property_owner_name'] = $getData[$i]->property_owner_name;
                    // $property_address = 
                    $returnData['data'][$i]['property_unit_id'] = $this->encode($getData[$i]['property_unit_id']);
                    $returnData['data'][$i]['property_name'] = $getData[$i]['property_name'];
                    $returnData['data'][$i]['property_unit_name'] = $getData[$i]['property_unit_name'];
                    $returnData['data'][$i]['invoice_type'] = $getData[$i]['invoice_type'];
                    $returnData['data'][$i]['invoice_date_gen'] = $getData[$i]['invoice_date_gen'];
                    $returnData['data'][$i]['amount_type'] = $getData[$i]['amount_type'];
                    $returnData['data'][$i]['amount_total'] = $getData[$i]['amount_total'];
                    $returnData['data'][$i]['status'] = $getData[$i]['status'];
                    $returnData['data'][$i]['transaction_number'] = $getData[$i]['transaction_number'];
                    $returnData['data'][$i]['notes'] = $getData[$i]['notes'];
                    $returnData['data'][$i]['transaction_date'] = $getData[$i]['transaction_date'];
                    $returnData['data'][$i]['due_date'] = $getData[$i]['due_date'];
                    $returnData['data'][$i]['email_sent'] = $getData[$i]['email_sent'];
                    $returnData['data'][$i]['property_owners_invoice'] = $getData[$i]['property_owners_invoice'];
                    $returnData['data'][$i]['created_at'] = $getData[$i]['created_at'];
                    $returnData['data'][$i]['updated_at'] = $getData[$i]['updated_at'];
                    $returnData['data'][$i]['deleted_at'] = $getData[$i]['deleted_at'];
                }
                $returnData['company_details']['company_name'] = $company_details->name;
                $returnData['company_details']['company_address'] = $company_details->address;
                $returnData['company_details']['company_email'] = $company_details->email;



                $returnData['meta']['pagination']['total'] = $getData->total();
                $returnData['meta']['pagination']['count'] = $getData->count();
                $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            } else {
                $returnData = [
                    'message' => 'Data Not Found',
                    'object' => 'pro_rentals_invoice',
                    'data' => [],
                ];
                $returnData['meta']['pagination']['total'] = $getData->total();
                $returnData['meta']['pagination']['count'] = $getData->count();
                $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            }
            return $returnData;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
