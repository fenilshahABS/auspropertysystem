<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoiceManualProperty\Data\Repositories\RentalInvoiceManualPropertyRepository;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualDetailsProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceTransactionsManualProperty;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalInvoiceManualsPropertyTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RentalInvoiceManualPropertyRepository $repository
    ) {
    }

    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run($InputData, $request)
    {
        try {
            $per_page = (int) $InputData->getPerPage();
            //$property_master_id = $this->decode($InputData->getPropertyId());
            if ($request->flag == 'reports') {
              $property_master_id = $this->decode($InputData->getPropertyMasterID());
              $property_master_details_id = $this->decode($InputData->getPropertyMasterDetailsID());
            }else{
              $property_master_id = $this->decode($InputData->getPropertyId());
              $property_master_details_id = $this->decode($InputData->getPropertyUnitId());
            }

            $status = $InputData->getStatus();
            $user_id = $this->decode($InputData->getUserId());
            $from = $InputData->getFrom();
            $to = $InputData->getTo();
            $per_page = $InputData->getPerPage();
            $query = RentalInvoiceManualProperty::select(
                'pro_rentals_invoice_manual_property.*',
                'tenant_user.first_name as tenant_name'

            )
                ->leftjoin('pro_rentals_property_management', 'pro_rentals_property_management.id', 'pro_rentals_invoice_manual_property.rent_id')

                ->leftjoin('pro_tenantusers as tenant_user', 'tenant_user.id', 'pro_rentals_property_management.user_id');

            if (!empty($user_id)) {

                $query->addSelect('property_owner.first_name as property_owner_name');
                $query->leftjoin('pro_property_master_share_details', 'pro_property_master_share_details.pro_property_master_id', 'pro_rentals_invoice_manual_property.property_id');
                $query->leftjoin('pro_tenantusers as property_owner', 'property_owner.id', 'pro_property_master_share_details.property_owner_id');
                $query->where('pro_property_master_share_details.property_owner_id', $user_id);
            }

            if (!empty($property_master_id)) {
                $query->where('pro_rentals_invoice_manual_property.property_id', $property_master_id);
            }
            if ($status != "") {
                $query->where('pro_rentals_invoice_manual_property.status', $status);
            }

            if (!empty($from) && !empty($to)) {
                $query->where('pro_rentals_invoice_manual_property.invoice_date_gen', '>=', $from);
                $query->where('pro_rentals_invoice_manual_property.invoice_date_gen', '<=', $to);
            }
            if ($request->flag == 'reports') {
                $getData = $query->orderBy('pro_rentals_invoice_manual_property.id', 'DESC')->get();
            } else {
                $getData = $query->orderBy('pro_rentals_invoice_manual_property.id', 'DESC')->paginate($per_page);
            }

            $returnData = array();
            $returnDetails = array();
            //   $returnShareDetails = array();
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                    $returnData['data'][$i]['invoice_id'] = $getData[$i]['id'];
                    $returnData['data'][$i]['invoice_number'] = $getData[$i]['invoice_number'];
                    $returnData['data'][$i]['rent_id'] = $this->encode($getData[$i]['rent_id']);
                    //      $dueDate = RentalPropertyManagement::where('rent_date')
                    $returnData['data'][$i]['tenant_name'] = $getData[$i]['tenant_name'];
                    $returnData['data'][$i]['firm_name'] = $getData[$i]['firm_name'];
                    $returnData['data'][$i]['property_id'] = $this->encode($getData[$i]['property_id']);
                    // $property_address =
                    $returnData['data'][$i]['property_owner_name'] = $getData[$i]['property_owner_name'] ?? "";
                    $returnData['data'][$i]['property_name'] = $getData[$i]['property_name'];
                    $returnData['data'][$i]['invoice_type'] = $getData[$i]['invoice_type'];
                    $returnData['data'][$i]['invoice_date_gen'] = $getData[$i]['invoice_date_gen'];
                    $returnData['data'][$i]['amount_type'] = $getData[$i]['amount_type'];
                    $returnData['data'][$i]['amount_total'] = $getData[$i]['amount_total'];
                    $returnData['data'][$i]['pending_amount'] = $getData[$i]['pending_amount'];
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


                    $rentalInvoiceManualDetails = RentalInvoiceManualDetailsProperty::where('rent_invoice_id', $getData[$i]['id'])->get();
                    $returnDetails = array();
                    if (!empty($rentalInvoiceManualDetails) && count($rentalInvoiceManualDetails)) {
                        for ($j = 0; $j < count($rentalInvoiceManualDetails); $j++) {
                            $returnDetails[$j]['id'] = $this->encode($rentalInvoiceManualDetails[$j]->id);
                            $returnDetails[$j]['rent_invoice_id'] = $this->encode($rentalInvoiceManualDetails[$j]->rent_invoice_id);
                            $returnDetails[$j]['service_name'] = $rentalInvoiceManualDetails[$j]->service_name;
                            $returnDetails[$j]['amount'] = $rentalInvoiceManualDetails[$j]->amount;
                            $returnDetails[$j]['description'] = $rentalInvoiceManualDetails[$j]->description;
                            $returnDetails[$j]['is_tax_applied'] = $rentalInvoiceManualDetails[$j]->is_tax_applied;
                            $returnDetails[$j]['tax'] = $rentalInvoiceManualDetails[$j]->tax;
                            $returnDetails[$j]['tax_amount'] = $rentalInvoiceManualDetails[$j]->tax_amount;
                        }
                    } else {
                        $returnDetails = [];
                    }
                    $returnData['data'][$i]['rental_invoice_details'] = $returnDetails;

                    $rental_invoice_transactions = RentalInvoiceTransactionsManualProperty::where('rental_invoice_id', $getData[$i]['id'])->orderBy('id', 'DESC')->get();
                    $returnDataInvoiceTransactions = array();
                    if (!empty($rental_invoice_transactions) && count($rental_invoice_transactions)) {
                        for ($m = 0; $m < count($rental_invoice_transactions); $m++) {
                            $returnDataInvoiceTransactions[$m]['id'] = $this->encode($rental_invoice_transactions[$m]->id);
                            $returnDataInvoiceTransactions[$m]['rental_invoice_id'] = $rental_invoice_transactions[$m]->rental_invoice_id;
                            $returnDataInvoiceTransactions[$m]['amount_type'] = $rental_invoice_transactions[$m]->amount_type;
                            $returnDataInvoiceTransactions[$m]['amount'] = $rental_invoice_transactions[$m]->amount;
                            $returnDataInvoiceTransactions[$m]['status'] = $rental_invoice_transactions[$m]->status;
                            $returnDataInvoiceTransactions[$m]['transaction_number'] = $rental_invoice_transactions[$m]->transaction_number;
                            $returnDataInvoiceTransactions[$m]['notes'] = $rental_invoice_transactions[$m]->notes;
                            $returnDataInvoiceTransactions[$m]['transaction_date'] = $rental_invoice_transactions[$m]->transaction_date;
                        }
                    } else {
                        $returnDataInvoiceTransactions = [];
                    }
                    $returnData['data'][$i]['invoice_transaction_details'] = $returnDataInvoiceTransactions;

                }
                if ($request->flag != 'reports') {
                    $returnData['meta']['pagination']['total'] = $getData->total();
                    $returnData['meta']['pagination']['count'] = $getData->count();
                    $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                    $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                    $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                    $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                    $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
                }
            } else {
                $returnData['message'] = "Data Not Found";
                $returnData['object'] = "pro_rentals_property_management_expense";

                if ($request->flag != 'reports') {
                    $returnData['meta']['pagination']['total'] = $getData->total();
                    $returnData['meta']['pagination']['count'] = $getData->count();
                    $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                    $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                    $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                    $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                    $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
                }else{
                    $returnData['data'] = array();
                }
            }
            return $returnData;
        } catch (Exception $e) {
            return $e;
        }
    }
}
