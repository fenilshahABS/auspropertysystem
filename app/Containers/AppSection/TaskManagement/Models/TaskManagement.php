<?php

namespace App\Containers\AppSection\TaskManagement\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class TaskManagement extends ParentModel
{
    protected $table = "pro_task_management";
    protected $fillable = [
        "id",
        "user_id",
        "task_name",
        "task_details",
        "task_inspection_date",
        "task_inspection_time",
        "task_datetime",
        "custom_email",
        "status"
    ];

    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'TaskManagement';
}
