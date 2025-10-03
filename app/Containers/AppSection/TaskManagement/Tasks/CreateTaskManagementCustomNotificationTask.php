<?php

namespace App\Containers\AppSection\TaskManagement\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\TaskManagement\Data\Repositories\TaskManagementRepository;
use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Containers\AppSection\TaskManagement\Models\TaskManagementCustomNotification;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreateTaskManagementCustomNotificationTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TaskManagementRepository $repository
    ) {
    }


    public function run($data, $InputData)
    {
        //        try {
        $id = $this->decode($InputData->getId());
        if (!empty($id)) {
            $update = TaskManagementCustomNotification::where('id', $id)->update($data);
            if ($update) {
                $returnData['message'] = "Data Updated Successfully";
            } else {
                $returnData['message'] = "Failed To Update!";
            }
        } else {
            $create = TaskManagementCustomNotification::create($data);
            if ($create) {
                $returnData['message'] = "Data Created Successfully";
            } else {
                $returnData['message'] = "Failed To Create!";
            }
        }
        return $returnData;
        // } catch (Exception) {
        //     throw new CreateResourceFailedException();
        // }
    }
}
