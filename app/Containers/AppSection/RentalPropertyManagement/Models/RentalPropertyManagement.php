<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class RentalPropertyManagement extends ParentModel
{
    protected $table = 'pro_rentals_property_management';
    protected $fillable = [
        "id",
        "property_master_id",
        "pro_property_master_details_id",
        "lease_start_date",
        "lease_end_date",
        "user_id",
        "rent_date",
        "rent_frequency",
        "rent_amount",
        "security_deposit",
        "advance_amount",
        "late_fees",
        "lease_document",
        "rent_created_at",
        "lease_status",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'RentalPropertyManagement';
}
