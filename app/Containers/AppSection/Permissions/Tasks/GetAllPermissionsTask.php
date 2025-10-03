<?php

namespace App\Containers\AppSection\Permissions\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Permissions\Data\Repositories\PermissionsRepository;
use App\Containers\AppSection\Permissions\Models\Permissions;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllPermissionsTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PermissionsRepository $repository
    ) {
    }


    public function run()
    {
        try {
            $returnData = array();
            $getData = Permissions::get();
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['object'] = "pro_permission";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['name'] = $getData[$i]->name;
                    $returnData['data'][$i]['key'] = $getData[$i]->key;
                    $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
                    $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;
                }
            } else {
                $returnData = [
                    'message' => 'Data Not Found',
                    'object' => 'pro_permission',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
