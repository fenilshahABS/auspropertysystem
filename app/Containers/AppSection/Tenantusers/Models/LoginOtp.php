<?php

namespace App\Containers\AppSection\Tenantusers\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class LoginOtp extends ParentModel
{
    protected $table = "events_login_otp";
    protected $fillable = [
        "id",
        "mobile",
        "mobileotp",
        "email",
        "emailotp",
        "is_verify",
        "verified_at",
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
    protected string $resourceKey = 'LoginOtp';
}
