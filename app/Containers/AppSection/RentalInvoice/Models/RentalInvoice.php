<?php

namespace App\Containers\AppSection\RentalInvoice\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class RentalInvoice extends ParentModel
{
    protected $table = 'pro_rentals_invoice';
    protected $fillable = [
        "id",
        "rent_id",
        "invoice_type",
        "invoice_date_gen",
        "amount_total",
        "pending_amount",
        "status",
        "transaction_number",
        "notes",
        "transaction_date",
        "email_sent",
        "property_owners_invoice",
        "tax",
        "tax_amount",
        "created_at",
        "updated_at",
        "deleted_at",
    ];


    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'RentalInvoice';
}
