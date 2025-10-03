<?php

namespace App\Containers\AppSection\Notifications\Tasks;

use App\Containers\AppSection\Notifications\Data\Repositories\NotificationsRepository;
use App\Containers\AppSection\Notifications\Models\Notifications;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateNotificationsTask extends ParentTask
{
    protected NotificationsRepository $repository;
    public function __construct(NotificationsRepository $repository)
    {
        $this->repository = $repository;
    }


    public function run($id)
    {
        try {
            $updateData = Notifications::where('id', $id)->update(["is_seen" => 1]);
            $returnData = array();
            $returnData['result'] = true;
            $returnData['message'] = "Notification status has been updated ";
            $returnData['object'] = "pro_notifications";
            return $returnData;
            //  return $this->repository->update($data, $id);
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to update the resource. Please try again later.',
                'object' => 'pro_notifications',
                'data' => [],
            ];
        }
    }
}
