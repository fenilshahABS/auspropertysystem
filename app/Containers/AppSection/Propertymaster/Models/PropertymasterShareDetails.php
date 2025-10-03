<?php

namespace App\Containers\AppSection\Propertymaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class PropertymasterShareDetails extends ParentModel
{
    protected $table = "pro_property_master_share_details";
    protected $fillable = [
        "id",
        "pro_property_master_id",
        "property_owner_id",
        "ownership_share",
    ];

    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'PropertymasterShareDetails';
}
