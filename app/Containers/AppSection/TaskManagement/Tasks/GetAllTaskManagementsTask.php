<?php

namespace App\Containers\AppSection\TaskManagement\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\TaskManagement\Data\Repositories\TaskManagementRepository;
use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllTaskManagementsTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TaskManagementRepository $repository
    ) {
    }


    public function run($id)
    {
        try {
            $returnData = array();

            $getData = TaskManagement::where('user_id', $id)->orderBy('created_at', 'DESC')->get();

            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['object'] = "pro_task_management";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['user_id'] = $this->encode($getData[$i]->user_id);
                    $returnData['data'][$i]['task_name'] = $getData[$i]->task_name;
                    $returnData['data'][$i]['task_details'] = $getData[$i]->task_details;
                    $returnData['data'][$i]['task_inspection_date'] = $getData[$i]->task_inspection_date;
                    $returnData['data'][$i]['task_inspection_time'] = $getData[$i]->task_inspection_time;
                    $returnData['data'][$i]['task_datetime'] = $getData[$i]->task_datetime;
                    $returnData['data'][$i]['custom_email'] = $getData[$i]->custom_email;
                    $returnData['data'][$i]['status'] = $getData[$i]->status;
                    $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
                    $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;
                }
            } else {
                $returnData = [
                    'message' => 'Data Not Found',
                    'object' => 'pro_task_management',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
