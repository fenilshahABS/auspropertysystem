<?php

namespace App\Containers\AppSection\Propertymaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class Propertymaster extends ParentModel
{
    protected $table = "pro_property_master";
    protected $fillable = [
        "id",
        "type_id",
        "type",
        "firm_name",
        "property_purchase_price",
        "property_purchase_date",
        "property_current_market_value",
        "property_name",
        "property_owner",
        // "property_owner_id",
        "property_owner_commission_amount",
        "property_owner_commission_percentage",
        "property_address_1",
        "property_address_2",
        "property_city",
        "property_state",
        "property_country",
        "property_zipcode",
        "status",
    ];

    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Propertymaster';
}
