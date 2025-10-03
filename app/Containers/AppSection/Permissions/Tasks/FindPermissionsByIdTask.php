<?php

namespace App\Containers\AppSection\Permissions\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Permissions\Data\Repositories\PermissionsRepository;
use App\Containers\AppSection\Permissions\Models\Permissions;
use App\Containers\AppSection\Permissions\Models\RolePermissions;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class FindPermissionsByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PermissionsRepository $repository
    ) {
    }


    public function run($id)
    {
        try {

            $returnData = array();
            $getData = RolePermissions::where('role_id', $id)->get();

            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['object'] = "pro_role_permission";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['role_id'] = $this->encode($getData[$i]->role_id);
                    $returnData['data'][$i]['permission_id'] = $this->encode($getData[$i]->permission_id);
                    $returnData['data'][$i]['status'] = $getData[$i]->status;
                    $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
                    $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;
                }
            } else {
                $returnData = [
                    'message' => 'Data Not Found',
                    'object' => 'pro_role_permission',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception) {
            throw new NotFoundException();
        }
    }
}
