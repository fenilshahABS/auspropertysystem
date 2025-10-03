<?php

namespace App\Containers\AppSection\Permissions\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class Permissions extends ParentModel
{
    protected $table = "pro_permissions";
    protected $fillable = [
        "id",
        "name",
        "key",
    ];

    protected $hidden = [];

    protected $casts = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Permissions';
}
