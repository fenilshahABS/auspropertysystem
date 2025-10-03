<?php

namespace App\Containers\AppSection\RentalInvoice\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jp_tenantusers")
 */
class RentalInvoice
{
    protected $rental_invoice_id;
    protected $description;
    protected $amount;
    protected $amount_type;
    protected $transaction_number;
    protected $user_id;
    protected $property_master_id;
    protected $pro_property_master_details_id;
    protected $from;
    protected $to;
    protected $unit;
    protected $status;
    protected $notes;
    protected $search_val;
    protected $field_db;
    protected $per_page;
    protected $transactions_date;

    public function __construct($request = null)
    {
        $this->description             = isset($request['description']) ? $request['description'] : null;
        $this->rental_invoice_id             = isset($request['rental_invoice_id']) ? $request['rental_invoice_id'] : null;
        $this->amount_type             = isset($request['amount_type']) ? $request['amount_type'] : null;
        $this->amount             = isset($request['amount']) ? $request['amount'] : null;
        $this->transaction_number             = isset($request['transaction_number']) ? $request['transaction_number'] : null;
        $this->from             = isset($request['from']) ? $request['from'] : null;
        $this->to             = isset($request['to']) ? $request['to'] : null;
        $this->property_master_id             = isset($request['property_master_id']) ? $request['property_master_id'] : null;
        $this->pro_property_master_details_id             = isset($request['pro_property_master_details_id']) ? $request['pro_property_master_details_id'] : null;
        $this->user_id             = isset($request['user_id']) ? $request['user_id'] : null;
        $this->notes          = isset($request['notes']) ? $request['notes'] : null;
        $this->status          = isset($request['status']) ? $request['status'] : null;
        $this->transactions_date          = isset($request['transactions_date']) ? $request['transactions_date'] : null;

        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->per_page = isset($request['per_page']) ? $request['per_page'] : null;
    }


    public function getTransactionsDate()
    {
        return $this->transactions_date;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getRentalInvoiceId()
    {
        return $this->rental_invoice_id;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function getAmountType()
    {
        return $this->amount_type;
    }
    public function getTransactionNumber()
    {
        return $this->transaction_number;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getPropertyMasterId()
    {
        return $this->property_master_id;
    }
    public function getPropertyMasterDetailsId()
    {
        return $this->pro_property_master_details_id;
    }

    public function getFrom()
    {
        return $this->from;
    }
    public function getTo()
    {
        return $this->to;
    }
    public function getNotes()
    {
        return $this->notes;
    }

    public function getStatus()
    {
        return $this->status;
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
