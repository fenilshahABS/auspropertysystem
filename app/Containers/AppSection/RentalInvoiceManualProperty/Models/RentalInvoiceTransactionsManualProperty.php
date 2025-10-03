<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class RentalInvoiceTransactionsManualProperty extends ParentModel
{
    protected $table = 'pro_rentals_invoice_transactions_manual_property';
    protected $fillable = [
        "id",
        "rental_invoice_id",
        "amount_type",
        "amount",
        "status",
        "transaction_number",
        "notes",
        "transaction_date",
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
