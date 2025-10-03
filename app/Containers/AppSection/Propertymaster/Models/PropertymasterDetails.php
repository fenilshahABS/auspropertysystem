<?php

namespace App\Containers\AppSection\Propertymaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class PropertymasterDetails extends ParentModel
{
    protected $table = "pro_property_master_details";
    protected $fillable = [
        "id",
        "pro_property_master_id",
        "units_name",
        "units_beds",
        "units_baths",
        "units_size",
        "market_rent",
        "property_photo_1",
        "property_photo_2",
        "property_photo_3",
        "property_status",
    ];

    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Propertymaster';
}
