<?php

namespace App\Containers\AppSection\Propertytype\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class Propertytype extends ParentModel
{
    protected $table = 'pro_property_type_master';
    protected $fillable = [
        'id',
        'type',
        'is_active'
    ];

    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Propertytype';
}
