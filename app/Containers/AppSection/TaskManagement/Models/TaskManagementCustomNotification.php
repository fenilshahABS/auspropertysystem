<?php

namespace App\Containers\AppSection\TaskManagement\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class TaskManagementCustomNotification extends ParentModel
{
    protected $table = "pro_task_management_custom_notifications";
    protected $fillable = [
        "id",
        "task_management_id",
        "task_datetime",
    ];

    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'TaskManagementCustomNotification';
}
