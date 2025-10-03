<?php

namespace App\Containers\AppSection\RentalInvoice\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class RentalOwnerShareInvoice extends ParentModel
{
    protected $table = 'pro_rental_owner_share_invoice';
    protected $fillable = [
        "id",
        "rent_invoice_id",
        "property_owner_id",
        "owner_share_amount",
        "transaction_number",
        "transaction_date",
        "status",
        "notes",
        "created_at",
        "updated_at",
        "deleted_at",
    ];


    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'RentalOwnerShareInvoice';
}
