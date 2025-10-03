<?php

namespace App\Containers\AppSection\Permissions\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Permissions\Data\Repositories\PermissionsRepository;
use App\Containers\AppSection\Permissions\Models\Permissions;
use App\Containers\AppSection\Permissions\Models\RolePermissions;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdatePermissionsTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PermissionsRepository $repository
    ) {
    }

    public function run(array $data, $InputData)
    {
        try {
            $id = $this->decode($InputData->getId());

            if (!empty($id)) {
                $update = RolePermissions::where('id', $id)->update($data);
                $getData = RolePermissions::where('id', $id)->first();
            } else {
                $create = RolePermissions::create($data);
                $getData = RolePermissions::where('id', $create->id)->first();
            }
            if (!empty($getData)) {
                $returnData['message'] = "Data Found";
                $returnData['data']['object'] = "pro_role_permission";
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['role_id'] = $this->encode($getData->role_id);
                $returnData['data']['permission_id'] = $this->encode($getData->permission_id);
                $returnData['data']['status'] = $getData->status;
                $returnData['data']['created_at'] = $getData->created_at;
                $returnData['data']['updated_at'] = $getData->updated_at;
            } else {
                $returnData = [
                    'message' => 'Data Not Found',
                    'object' => 'pro_role_permission',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
