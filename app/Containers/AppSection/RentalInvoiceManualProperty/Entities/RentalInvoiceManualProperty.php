<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jp_tenantusers")
 */
class RentalInvoiceManualProperty
{
    protected $invoice_number;
    protected $user_id;
    protected $from;
    protected $to;
    protected $rent_id;
    protected $firm_name;
    protected $property_id;
    protected $property_unit_id;
    protected $property_name;
    protected $property_unit_name;
    protected $invoice_type;
    protected $invoice_pdf;
    protected $invoice_date_gen;
    protected $amount_type;
    protected $amount_total;
    protected $status;
    protected $transaction_number;
    protected $property_master_id;
    protected $pro_property_master_details_id;
    protected $notes;
    protected $transaction_date;
    protected $email_sent;
    protected $property_owners_invoice;
    protected $invoice_details;
    protected $due_date;
    protected $search_val;
    protected $field_db;
    protected $per_page;
    protected $amount;
    protected $rental_invoice_id;

    public function __construct($request = null)
    {
        $this->user_id             = isset($request['user_id']) ? $request['user_id'] : null;
        $this->due_date             = isset($request['due_date']) ? $request['due_date'] : null;
        $this->invoice_number             = isset($request['invoice_number']) ? $request['invoice_number'] : null;
        $this->from             = isset($request['from']) ? $request['from'] : null;
        $this->to             = isset($request['to']) ? $request['to'] : null;
        $this->property_id = isset($request['property_id']) ? $request['property_id'] : null;
        $this->property_unit_id = isset($request['property_unit_id']) ? $request['property_unit_id'] : null;
        $this->property_master_id = isset($request['property_master_id']) ? $request['property_master_id'] : null;
        $this->pro_property_master_details_id = isset($request['pro_property_master_details_id']) ? $request['pro_property_master_details_id'] : null;
        $this->rent_id = isset($request['rent_id']) ? $request['rent_id'] : null;
        $this->firm_name = isset($request['firm_name']) ? $request['firm_name'] : null;
        $this->property_name = isset($request['property_name']) ? $request['property_name'] : null;
        $this->property_unit_name = isset($request['property_unit_name']) ? $request['property_unit_name'] : null;
        $this->invoice_type = isset($request['invoice_type']) ? $request['invoice_type'] : null;
        $this->invoice_pdf = isset($request['invoice_pdf']) ? $request['invoice_pdf'] : null;
        $this->invoice_date_gen = isset($request['invoice_date_gen']) ? $request['invoice_date_gen'] : null;
        $this->amount_type = isset($request['amount_type']) ? $request['amount_type'] : null;
        $this->amount_total = isset($request['amount_total']) ? $request['amount_total'] : null;
        $this->status = isset($request['status']) ? $request['status'] : null;
        $this->transaction_number = isset($request['transaction_number']) ? $request['transaction_number'] : null;
        $this->notes = isset($request['notes']) ? $request['notes'] : null;
        $this->transaction_date = isset($request['transaction_date']) ? $request['transaction_date'] : null;
        $this->email_sent = isset($request['email_sent']) ? $request['email_sent'] : null;
        $this->property_owners_invoice = isset($request['property_owners_invoice']) ? $request['property_owners_invoice'] : null;
        $this->invoice_details = isset($request['invoice_details']) ? $request['invoice_details'] : null;
        $this->amount = isset($request['amount']) ? $request['amount'] : null;
        $this->rental_invoice_id = isset($request['rental_invoice_id']) ? $request['rental_invoice_id'] : null;

        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->per_page = isset($request['per_page']) ? $request['per_page'] : null;
    }

    public function getAmount()
    {
        return $this->amount;
    }
    public function getRentalInvoiceId()
    {
        return $this->rental_invoice_id;
    }
    public function getPropertyMasterID()
    {
        return $this->property_master_id;
    }
    public function getPropertyMasterDetailsID()
    {
        return $this->pro_property_master_details_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getDueDate()
    {
        return $this->due_date;
    }

    public function getInvoiceNumber()
    {
        return $this->invoice_number;
    }

    public function getFrom()
    {
        return $this->from;
    }
    public function getTo()
    {
        return $this->to;
    }
    public function getPropertyId()
    {
        return $this->property_id;
    }

    public function getPropertyUnitId()
    {
        return $this->property_unit_id;
    }

    public function getInvoiceDetails()
    {
        return $this->invoice_details;
    }

    public function getRentId()
    {
        return $this->rent_id;
    }

    public function getFirmName()
    {
        return $this->firm_name;
    }

    public function getPropertyName()
    {
        return $this->property_name;
    }

    public function getPropertyUnitName()
    {
        return $this->property_unit_name;
    }

    public function getInvoiceType()
    {
        return $this->invoice_type;
    }

    public function getInvoicePdf()
    {
        return $this->invoice_pdf;
    }

    public function getInvoiceDateGen()
    {
        return $this->invoice_date_gen;
    }

    public function getAmountType()
    {
        return $this->amount_type;
    }

    public function getAmountTotal()
    {
        return $this->amount_total;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getTransactionNumber()
    {
        return $this->transaction_number;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function getTransactionDate()
    {
        return $this->transaction_date;
    }

    public function getEmailSent()
    {
        return $this->email_sent;
    }

    public function getPropertyOwnersInvoice()
    {
        return $this->property_owners_invoice;
    }


    public function getSearchVal()
    {
        return $this->search_val;
    }

    public function getFieldDB()
    {
        return $this->field_db;
    }

    public function getPerPage()
    {
        return $this->per_page;
    }
}
