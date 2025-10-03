<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class RentalInvoiceManualDetails extends ParentModel
{
    protected $table = 'pro_rentals_invoice_child_manual';
    protected $fillable = [
        "id",
        "rent_invoice_id",
        "service_name",
        "amount",
        "description",
        "is_tax_applied",
        "tax",
        "tax_amount",
        "status",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'RentalInvoiceManualDetails';
}
