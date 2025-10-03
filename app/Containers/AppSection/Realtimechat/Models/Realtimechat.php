<?php

namespace App\Containers\AppSection\Realtimechat\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class Realtimechat extends ParentModel
{
    protected $table = 'pro_chatting_internally';
    protected $fillable = [
        "id",
        "to_user_id",
        "type",
        "message",
        "image",
        "chatting_date_time",
        "status",
        "sender_type",
        "sent_user_id",
        "sent_user_name",
        "view_system_user_id",
        "view_system_user_name",
    ];

    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Realtimechat';
}
