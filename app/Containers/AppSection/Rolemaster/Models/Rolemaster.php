<?php

namespace App\Containers\AppSection\Rolemaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rolemaster extends ParentModel
{
    use SoftDeletes;
    protected $table = "pro_roles";
    protected $fillable = [
        "id",
        "name",
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
    protected string $resourceKey = 'Rolemaster';
}
