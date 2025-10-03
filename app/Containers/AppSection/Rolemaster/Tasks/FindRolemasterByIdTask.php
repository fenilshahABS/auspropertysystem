<?php

namespace App\Containers\AppSection\Rolemaster\Tasks;

use App\Containers\AppSection\Rolemaster\Data\Repositories\RolemasterRepository;
use App\Containers\AppSection\Rolemaster\Models\Rolemaster;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class FindRolemasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RolemasterRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $getData = Rolemaster::where('id', $id)->first();
            if ($getData != "") {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['data']['object'] = 'Role Master';
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
                $returnData['data']['created_at'] = $getData->created_at;
                $returnData['data']['updated_at'] = $getData->updated_at;
            }else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Role Master";
            }
        return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'Role Master',
                'data' => [],
            ];
        }
    }
}
