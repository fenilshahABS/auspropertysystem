<?php

namespace App\Containers\AppSection\Workermaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class Workermaster extends ParentModel
{
    protected $table = 'pro_worker_master';
    protected $fillable = [
        "id",
        "worker_name",
        "worker_mobile_no",
        "worker_email",
        "worker_address",
        "worker_city",
        "worker_zip_code",
        "worker_country",
        "worker_state",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Workermaster';
}
