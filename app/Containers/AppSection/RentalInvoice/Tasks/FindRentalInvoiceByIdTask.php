<?php

namespace App\Containers\AppSection\RentalInvoice\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoice\Data\Repositories\RentalInvoiceRepository;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoiceChild;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoiceTransactions;
use App\Containers\AppSection\RentalInvoice\Models\RentalOwnerShareInvoice;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class FindRentalInvoiceByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RentalInvoiceRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $returnData = array();
            $company_details = Themesettings::where('id', 1)->first();


            $query = RentalInvoice::select(
                'pro_rentals_invoice.*',
                'pro_property_master.property_name',
                'pro_property_master.property_address_1',
                'pro_property_master.property_address_2',
                'pro_property_master.property_city',
                'pro_property_master.property_state',
                'pro_property_master.property_country',
                'pro_property_master.property_zipcode',
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
            // if (!empty($property_master_id)) {
            //     $query->where('pro_rentals_property_management.property_master_id', $property_master_id);
            // }
            // if (!empty($property_master_details_id)) {
            //     $query->where('pro_rentals_property_management.pro_property_master_details_id', $property_master_details_id);
            // }
            // if ($status != "") {

            //     $query->where('pro_rentals_invoice.status', $status);
            // }
            // if (!empty($from) && !empty($to)) {
            //     $query->where('pro_rentals_invoice.invoice_date_gen', '>=', $from);
            //     $query->where('pro_rentals_invoice.invoice_date_gen', '<=', $to);
            // }
            $getData = $query->where('pro_rentals_invoice.id', $id)->first();


            //  $getData = RentalInvoice::where('id', $id)->first();
            $returnInvoiceDetails = array();
            if (!empty($getData)) {
                $returnData['message'] = "Data Found";
                $returnData['data']['object'] = "pro_rentals_invoice";
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['recipt_no'] = $getData->invoice_type.$getData->id;
                $returnData['data']['rent_id'] = $this->encode($getData->rent_id);
                $returnData['data']['property_name'] = $getData->property_name;
                $returnData['data']['units_name'] = $getData->units_name;
                $returnData['data']['tenant_name'] = $getData->tenant_name;
                $returnData['data']['invoice_type'] = $getData->invoice_type;
                $returnData['data']['invoice_date_gen'] = $getData->invoice_date_gen;
                $returnData['data']['amount_total'] = $getData->amount_total;
                $returnData['data']['pending_amount'] = $getData->pending_amount;
                $returnData['data']['status'] = $getData->status;
                $returnData['data']['transaction_number'] = $getData->transaction_number;
                $returnData['data']['notes'] = $getData->notes;
                $returnData['data']['transaction_date'] = $getData->transaction_date;
                $returnData['data']['created_at'] = $getData->created_at;
                $returnData['data']['updated_at'] = $getData->updated_at;
                $returnData['data']['tax'] = $getData->tax;
                $returnData['data']['tax_amount'] = $getData->tax_amount;
                $returnData['data']['company_name'] = $company_details->name;
                //$returnData['data']['company_address'] = $company_details->address;
                $returnData['data']['company_address'] = $getData->property_address_2." ".$getData->property_city." ".$getData->property_state." ".$getData->property_country." ".$getData->property_zipcdoe;
                $returnData['data']['company_email'] = $company_details->email;

                $getInvoiceDetails = RentalInvoiceChild::where('rent_invoice_id', $getData->id)->get();
                if (!empty($getInvoiceDetails) && count($getInvoiceDetails) >= 1) {
                    for ($i = 0; $i < count($getInvoiceDetails); $i++) {
                        $returnInvoiceDetails[$i]['id'] = $this->encode($getInvoiceDetails[$i]->id);
                        $returnInvoiceDetails[$i]['rent_invoice_id'] = $this->encode($getInvoiceDetails[$i]->rent_invoice_id);
                        $returnInvoiceDetails[$i]['amount'] = $getInvoiceDetails[$i]->amount;
                        $returnInvoiceDetails[$i]['description'] = $getInvoiceDetails[$i]->description;
                        $returnInvoiceDetails[$i]['status'] = $getInvoiceDetails[$i]->status;
                        $returnInvoiceDetails[$i]['created_at'] = $getInvoiceDetails[$i]->created_at;
                        $returnInvoiceDetails[$i]['updated_at'] = $getInvoiceDetails[$i]->updated_at;
                    }
                } else {
                    $returnInvoiceDetails = [];
                }
                $returnData['data']['late_fees_details'] = $returnInvoiceDetails;


                $property_owner_share_details = RentalOwnerShareInvoice::where('rent_invoice_id', $getData->id)->get();
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
                $returnData['data']['owner_share_details'] = $returnDataOwnerShare;

                $rental_invoice_transactions = RentalInvoiceTransactions::where('rental_invoice_id', $getData->id)->orderBy('id', 'DESC')->get();
                if (!empty($rental_invoice_transactions) && count($rental_invoice_transactions)) {
                    for ($m = 0; $m < count($rental_invoice_transactions); $m++) {
                        $returnDataInvoiceTransactions[$m]['id'] = $this->encode($rental_invoice_transactions[$m]->id);
                        $returnDataInvoiceTransactions[$m]['rental_invoice_id'] = $rental_invoice_transactions[$m]->rental_invoice_id;
                        $returnDataInvoiceTransactions[$m]['amount_type'] = $rental_invoice_transactions[$m]->amount_type;
                        $returnDataInvoiceTransactions[$m]['payment_type'] = $rental_invoice_transactions[$m]->amount_type;
                        if($rental_invoice_transactions[$m]->amount_type==1){
                          $returnDataInvoiceTransactions[$m]['payment_type_label'] = "Cash";
                        }else{
                          $returnDataInvoiceTransactions[$m]['payment_type_label'] = "Check / Online";
                        }

                        $returnDataInvoiceTransactions[$m]['amount'] = $rental_invoice_transactions[$m]->amount;
                        $returnDataInvoiceTransactions[$m]['status'] = $rental_invoice_transactions[$m]->status;
                        $returnDataInvoiceTransactions[$m]['transaction_number'] = $rental_invoice_transactions[$m]->transaction_number;
                        $returnDataInvoiceTransactions[$m]['notes'] = $rental_invoice_transactions[$m]->notes;
                        $returnDataInvoiceTransactions[$m]['transaction_date'] = $rental_invoice_transactions[$m]->transaction_date;
                    }
                } else {
                    $returnDataInvoiceTransactions = [];
                }
                $returnData['data']['invoice_transaction_details'] = $returnDataInvoiceTransactions;
            } else {
                $returnData = [
                    'message' => 'Data Not Found',
                    'object' => 'pro_rentals_invoice',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
