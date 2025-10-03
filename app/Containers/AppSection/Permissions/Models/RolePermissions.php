<?php

namespace App\Containers\AppSection\Permissions\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class RolePermissions extends ParentModel
{
    protected $table = "pro_role_permission";
    protected $fillable = [
        "id",
        "role_id",
        "permission_id",
        "status",
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
    protected string $resourceKey = 'RolePermissions';
}
