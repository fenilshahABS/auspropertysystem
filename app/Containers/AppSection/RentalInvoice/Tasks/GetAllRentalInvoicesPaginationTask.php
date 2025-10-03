<?php

namespace App\Containers\AppSection\RentalInvoice\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoice\Data\Repositories\RentalInvoiceRepository;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoiceChild;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoiceTransactions;
use App\Containers\AppSection\RentalInvoice\Models\RentalOwnerShareInvoice;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Arr;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalInvoicesPaginationTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RentalInvoiceRepository $repository
    ) {
    }

    public function run($InputData, $request)
    {
        try {
            $returnData = array();
            $user_id = $this->decode($InputData->getUserId());

            $property_master_id = $this->decode($InputData->getPropertyMasterId());
            $property_master_details_id = $this->decode($InputData->getPropertyMasterDetailsId());
            $status = $InputData->getStatus();

            $from = $InputData->getFrom();
            $to = $InputData->getTo();
            $per_page = $InputData->getPerPage();
            $query = RentalInvoice::select(
                'pro_rentals_invoice.*',
                'pro_property_master.property_name',
                'pro_property_master_details.units_name',
                'tenant_user.first_name as tenant_name'
                // 'pro_property_master_share_details.ownerhip_share'
            )
                ->leftjoin('pro_rentals_property_management', 'pro_rentals_property_management.id', 'pro_rentals_invoice.rent_id')
                ->leftjoin('pro_property_master', 'pro_property_master.id', 'pro_rentals_property_management.property_master_id')
                ->leftjoin('pro_property_master_details', 'pro_property_master_details.id', 'pro_rentals_property_management.pro_property_master_details_id')
                ->leftjoin('pro_tenantusers as tenant_user', 'tenant_user.id', 'pro_rentals_property_management.user_id');
            if (!empty($user_id)) {
                $query->addSelect('property_owner.first_name as property_owner_name');
                $query->leftjoin('pro_property_master_share_details', 'pro_property_master_share_details.pro_property_master_id', 'pro_rentals_property_management.property_master_id');
                $query->leftjoin('pro_tenantusers as property_owner', 'property_owner.id', 'pro_property_master_share_details.property_owner_id');
                $query->where('pro_property_master_share_details.property_owner_id', $user_id);
            }
            if (!empty($property_master_id)) {
                $query->where('pro_rentals_property_management.property_master_id', $property_master_id);
            }
            if (!empty($property_master_details_id)) {
                $query->where('pro_rentals_property_management.pro_property_master_details_id', $property_master_details_id);
            }
            if ($status != "") {
                $query->where('pro_rentals_invoice.status', $status);
            }
            if (!empty($from) && !empty($to)) {
                $query->where('pro_rentals_invoice.invoice_date_gen', '>=', $from);
                $query->where('pro_rentals_invoice.invoice_date_gen', '<=', $to);
            }
            if ($request->flag == 'reports') {
                $getData = $query->orderBy('pro_rentals_invoice.id', 'DESC')->get();
            } else {
                $getData = $query->orderBy('pro_rentals_invoice.id', 'DESC')->paginate($per_page);
            }



            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['object'] = "pro_rentals_invoice";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['rent_id'] = $this->encode($getData[$i]->rent_id);
                    $returnData['data'][$i]['property_name'] = $getData[$i]->property_name;
                    $returnData['data'][$i]['property_owner_name'] = $getData[$i]->property_owner_name;
                    $returnData['data'][$i]['tenant_name'] = $getData[$i]->tenant_name;
                    $returnData['data'][$i]['units_name'] = $getData[$i]->units_name;
                    $returnData['data'][$i]['invoice_type'] = $getData[$i]->invoice_type;
                    $returnData['data'][$i]['invoice_date_gen'] = $getData[$i]->invoice_date_gen;
                    $returnData['data'][$i]['amount_total'] = $getData[$i]->amount_total;
                    $returnData['data'][$i]['pending_amount'] = $getData[$i]->pending_amount;
                    $returnData['data'][$i]['status'] = $getData[$i]->status;
                    $returnData['data'][$i]['transaction_number'] = $getData[$i]->transaction_number;
                    $returnData['data'][$i]['notes'] = $getData[$i]->notes;
                    $returnData['data'][$i]['tax'] = $getData[$i]->tax;
                    $returnData['data'][$i]['tax_amount'] = $getData[$i]->tax_amount;
                    $returnData['data'][$i]['transaction_date'] = $getData[$i]->transaction_date;


                    $getInvoiceDetails = RentalInvoiceChild::where('rent_invoice_id', $getData[$i]->id)->get();
                    if (!empty($getInvoiceDetails) && count($getInvoiceDetails) >= 1) {
                        for ($k = 0; $k < count($getInvoiceDetails); $k++) {
                            $returnInvoiceDetails[$k]['id'] = $this->encode($getInvoiceDetails[$k]->id);
                            $returnInvoiceDetails[$k]['rent_invoice_id'] = $this->encode($getInvoiceDetails[$k]->rent_invoice_id);
                            $returnInvoiceDetails[$k]['amount'] = $getInvoiceDetails[$k]->amount;
                            $returnInvoiceDetails[$k]['description'] = $getInvoiceDetails[$k]->description;
                            $returnInvoiceDetails[$k]['status'] = $getInvoiceDetails[$k]->status;
                            $returnInvoiceDetails[$k]['created_at'] = $getInvoiceDetails[$k]->created_at;
                            $returnInvoiceDetails[$k]['updated_at'] = $getInvoiceDetails[$k]->updated_at;
                        }
                    } else {
                        $returnInvoiceDetails = [];
                    }
                    $returnData['data'][$i]['late_fees_details'] = $returnInvoiceDetails;


                    $property_owner_share_details = RentalOwnerShareInvoice::where('rent_invoice_id', $getData[$i]->id)->get();
                    $returnDataOwnerShare = array();
                    if (!empty($property_owner_share_details) && count($property_owner_share_details) >= 1) {
                        for ($j = 0; $j < count($property_owner_share_details); $j++) {
                            $returnDataOwnerShare[$j]['id'] = $this->encode($property_owner_share_details[$j]->id);
                            $returnDataOwnerShare[$j]['rent_invoice_id'] = $this->encode($property_owner_share_details[$j]->rent_invoice_id);
                            $returnDataOwnerShare[$j]['property_owner_id'] = $property_owner_share_details[$j]->property_owner_id;
                            $property_owner_name = Tenantusers::find($property_owner_share_details[$j]->property_owner_id)->first_name;
                            $returnDataOwnerShare[$j]['property_owner_name'] = $property_owner_name;
                            $returnDataOwnerShare[$j]['owner_share_amount'] = $property_owner_share_details[$j]->owner_share_amount;
                            $returnDataOwnerShare[$j]['status'] = $property_owner_share_details[$j]->status;
                            $returnDataOwnerShare[$j]['transaction_number'] = $property_owner_share_details[$j]->transaction_number;
                            $returnDataOwnerShare[$j]['transaction_date'] = $property_owner_share_details[$j]->transaction_date;
                            $returnDataOwnerShare[$j]['notes'] = $property_owner_share_details[$j]->notes;
                            $returnDataOwnerShare[$j]['created_at'] = $property_owner_share_details[$j]->created_at;
                            $returnDataOwnerShare[$j]['updated_at'] = $property_owner_share_details[$j]->updated_at;
                        }
                    } else {
                        $returnDataOwnerShare = [];
                    }
                    $returnData['data'][$i]['owner_share_details'] = $returnDataOwnerShare;



                    $rental_invoice_transactions = RentalInvoiceTransactions::where('rental_invoice_id', $getData[$i]->id)->orderBy('id', 'DESC')->get();
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
                $returnData = [
                    'message' => 'Data Not Found',
                    'object' => 'pro_rentals_invoice',
                    'data' => [],
                ];
                if ($request->flag != 'reports') {
                    $returnData['meta']['pagination']['total'] = $getData->total();
                    $returnData['meta']['pagination']['count'] = $getData->count();
                    $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                    $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                    $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                    $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                    $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
                }
            }
            return $returnData;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
