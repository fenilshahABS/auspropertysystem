<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class RentalInvoiceManual extends ParentModel
{
    protected $table = 'pro_rentals_invoice_manual';
    protected $fillable = [
        "id",
        "invoice_number",
        "rent_id",
        "firm_name",
        "property_id",
        "property_name",
        "property_unit_id",
        "property_unit_name",
        "invoice_type",
        "invoice_date_gen",
        "amount_type",
        "amount_total",
        "pending_amount",
        "status",
        "transaction_number",
        "notes",
        "transaction_date",
        "email_sent",
        "property_owners_invoice",
        "due_date",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'RentalInvoiceManual';
}
