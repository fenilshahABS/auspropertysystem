<?php

namespace App\Containers\AppSection\Realtimechat\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Realtimechat\Data\Repositories\RealtimechatRepository;
use App\Containers\AppSection\Realtimechat\Models\Realtimechat;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class UpdateRealtimechatTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RealtimechatRepository $repository
    ) {
    }

    public function run($InputData)
    {
        try {
            $returnData = array();
            $getTenant = Auth::user();
            $to_user_id = $this->decode($InputData->getToUserId());
            $data = [
                "status" => 1,
                "view_system_user_id" => $getTenant['id'],
                "view_system_user_name" => Tenantusers::find($getTenant['id'])->first_name,
            ];
            if ($InputData->getFlag() == "admin") {
                $update = Realtimechat::where('to_user_id', $to_user_id)->whereIn('sender_type', [2, 3])->where('status', 0)->update($data);
            } else {
                $update = Realtimechat::where('to_user_id', $to_user_id)->where('sender_type', 1)->where('status', 0)->update($data);
            }

            if ($update) {
                $returnData['message'] =  "Data Updated";
            } else {
                $returnData['message'] =  "Nothing To Update";
            }
            return $returnData;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
