<?php

namespace App\Containers\AppSection\RentalInvoice\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class RentalInvoiceChild extends ParentModel
{
    protected $table = 'pro_rentals_invoice_child';
    protected $fillable = [
        "id",
        "rent_invoice_id",
        "amount",
        "description",
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
    protected string $resourceKey = 'RentalInvoice';
}
