<?php

namespace App\Containers\AppSection\TaskManagement\UI\API\Transformers;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Containers\AppSection\TaskManagement\Models\TaskManagementCustomNotification;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class TaskManagementTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];
    use HashIdTrait;
    public function transform(TaskManagement $taskmanagement): array
    {

        $returnDetails = array();
        $custom_notification_details = TaskManagementCustomNotification::where('task_management_id', $taskmanagement->id)->get();
        if (!empty($custom_notification_details) && count($custom_notification_details)) {
            for ($i = 0; $i < count($custom_notification_details); $i++) {
                $returnDetails[$i]['id'] = $this->encode($custom_notification_details[$i]->id);
                $returnDetails[$i]['task_management_id'] = $this->encode($custom_notification_details[$i]->task_management_id);
                $returnDetails[$i]['task_datetime'] = $custom_notification_details[$i]->task_datetime;
            }
        } else {
            $returnDetails = [];
        }

        $response = [
            'object' => $taskmanagement->getResourceKey(),
            'id' => $taskmanagement->getHashedKey(),
            'user_id' => $this->encode($taskmanagement->user_id),
            'task_name' => $taskmanagement->task_name,
            'task_details' => $taskmanagement->task_details,
            'task_inspection_date' => $taskmanagement->task_inspection_date,
            'task_inspection_time' => $taskmanagement->task_inspection_time,
            'task_datetime' => $taskmanagement->task_datetime,
            'custom_email' => $taskmanagement->custom_email,
            'status' => $taskmanagement->status,
            'created_at' => $taskmanagement->created_at,
            'updated_at' => $taskmanagement->updated_at,
            'custom_notification_details' => $returnDetails
        ];
        return $response;
        // return $this->ifAdmin([
        //     'real_id' => $taskmanagement->id,
        //     'created_at' => $taskmanagement->created_at,
        //     'updated_at' => $taskmanagement->updated_at,
        //     'readable_created_at' => $taskmanagement->created_at->diffForHumans(),
        //     'readable_updated_at' => $taskmanagement->updated_at->diffForHumans(),
        //     // 'deleted_at' => $taskmanagement->deleted_at,
        // ], $response);
    }
}
