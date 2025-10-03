<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Transformers;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualDetailsProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceTransactionsManualProperty;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class RentalInvoiceManualPropertyTransformer extends ParentTransformer
{
    use HashIdTrait;
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];

    public function transform(RentalInvoiceManualProperty $rentalinvoicemanual)
    {

        $rental_invoice_details = RentalInvoiceManualDetailsProperty::where('rent_invoice_id', $rentalinvoicemanual->id)->get();

        $returnDetails = array();
        if (!empty($rental_invoice_details) && count($rental_invoice_details)) {
            for ($i = 0; $i < count($rental_invoice_details); $i++) {
                $returnDetails[$i]['id'] = $this->encode($rental_invoice_details[$i]->id);
                $returnDetails[$i]['rent_invoice_id'] = $this->encode($rental_invoice_details[$i]->rent_invoice_id);
                $returnDetails[$i]['service_name'] = $rental_invoice_details[$i]->service_name;
                $returnDetails[$i]['amount'] = $rental_invoice_details[$i]->amount;
                $returnDetails[$i]['description'] = $rental_invoice_details[$i]->description;
                $returnDetails[$i]['is_tax_applied'] = $rental_invoice_details[$i]->is_tax_applied;
                $returnDetails[$i]['tax'] = $rental_invoice_details[$i]->tax;
                $returnDetails[$i]['tax_amount'] = $rental_invoice_details[$i]->tax_amount;
                $returnDetails[$i]['status'] = $rental_invoice_details[$i]->status;
            }
        } else {
            $returnDetails = [];
        }
        $image_api_url = Themesettings::select('name', 'address', 'email')->where('id', 1)->first();

        $name = "";
        $type = "";
        $address = "";
        $city = "";
        $state = "";
        $country = "";
        $zipcode = "";
        $property_Data = Propertymaster::select('property_name','type','property_address_1','property_address_2','property_city','property_state','property_country','property_zipcode')
                                        ->where('id', $rentalinvoicemanual->property_id)
                                        ->first();
        if(!empty($property_Data)){
          $name = $property_Data->property_name ?? "";
          $type = $property_Data->type ?? "";
          $address = "";
          if(!empty($property_Data)){
            $address = $property_Data->property_address_1." ".$property_Data->property_address_2;
          }
          $address =  $address;
          $city = $property_Data->property_city ?? "";
          $state = $property_Data->property_state ?? "";
          $country = $property_Data->property_country ?? "";
          $zipcode = $property_Data->property_zipcode ?? "";
        }

        $rental_invoice_transactions = RentalInvoiceTransactionsManualProperty::where('rental_invoice_id', $rentalinvoicemanual->id)->orderBy('id', 'DESC')->get();
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


        $response = [
            'object' => $rentalinvoicemanual->getResourceKey(),
            'id' => $rentalinvoicemanual->getHashedKey(),
            'invoice_id' => $rentalinvoicemanual->id,
            'invoice_number' => $rentalinvoicemanual->invoice_number,
            'rent_id' => $this->encode($rentalinvoicemanual->rent_id),
            'firm_name' => $rentalinvoicemanual->firm_name,
            'property_id' => $this->encode($rentalinvoicemanual->property_id),
            'property_name' => $rentalinvoicemanual->property_name,
            'name' => $name,
            'type' => $type,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'zipcode' => $zipcode,
            'invoice_type' => $rentalinvoicemanual->invoice_type,
            'invoice_date_gen' => $rentalinvoicemanual->invoice_date_gen,
            'amount_type' => $rentalinvoicemanual->amount_type,
            'amount_total' => $rentalinvoicemanual->amount_total,
            'pending_amount' => $rentalinvoicemanual->pending_amount,
            'status' => $rentalinvoicemanual->status,
            'transaction_number' => $rentalinvoicemanual->transaction_number,
            'notes' => $rentalinvoicemanual->notes,
            'transaction_date' => $rentalinvoicemanual->transaction_date,
            'due_date' => $rentalinvoicemanual->due_date,
            'email_sent' => $rentalinvoicemanual->email_sent,
            'property_owners_invoice' => $rentalinvoicemanual->property_owners_invoice,
            'created_at' => $rentalinvoicemanual->created_at,
            'updated_at' => $rentalinvoicemanual->updated_at,
            'deleted_at' => $rentalinvoicemanual->deleted_at,
            'invoice_details' => $returnDetails,
            'invoice_transaction_details' => $returnDataInvoiceTransactions,
            'company_name' => $image_api_url->name,
            'company_address' => $image_api_url->address,
            'company_email' => $image_api_url->email,
        ];
        return $response;


    }
}
