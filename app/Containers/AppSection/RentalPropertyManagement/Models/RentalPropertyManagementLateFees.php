<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class RentalPropertyManagementLateFees extends ParentModel
{
    protected $table = 'pro_rentals_property_management_late_fees';
    protected $fillable = [
        "id",
        "pro_rentals_property_management_id",
        "date_range_type",
        "date_range_value",
        "late_fees_amount",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'RentalPropertyManagementLateFees';
}
