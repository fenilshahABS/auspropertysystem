<?php

namespace App\Containers\AppSection\Tenantusers\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Tenantusers\Data\Repositories\TenantusersRepository;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;

use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateTenantusersTask extends Task
{
    use HashIdTrait;
    protected TenantusersRepository $repository;

    public function __construct(TenantusersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, $data)
    {
        try {
            $image_api_url = Themesettings::where('id', 1)->first();
            $data['mobile'] = (string) $data['mobile'];
            $update = Tenantusers::where('id', $id)->update($data);
            $getData = Tenantusers::where('id', $id)->first();
            $returnData = array();
            if (!empty($getData)) {
                $returnData['message'] = "Data Updated";
                $returnData['data']['object'] = "pro_tenantusers";
                $returnData['data']['id'] = $this->encode($getData['id']);
                $returnData['data']['role_id'] = $this->encode($getData['role_id']);
                $returnData['data']['first_name'] = $getData['first_name'];
                $returnData['data']['last_name'] = $getData['last_name'];
                $returnData['data']['profile_image'] = ($getData['profile_image']) ? $image_api_url->image_api_url . $getData['profile_image'] : "";
                $returnData['data']['id_proof'] = ($getData['id_proof']) ? $image_api_url->image_api_url . $getData['id_proof'] : "";
                $returnData['data']['dob'] = $getData['dob'];
                $returnData['data']['gender'] = $getData['gender'];
                $returnData['data']['email'] = $getData['email'];
                $returnData['data']['mobile'] = $getData['mobile'];
                $returnData['data']['address'] = $getData['address'];
                $returnData['data']['country'] = $getData['country'];
                $returnData['data']['state'] = $getData['state'];
                $returnData['data']['city'] = $getData['city'];
                $returnData['data']['zipcode'] = $getData['zipcode'];
                $returnData['data']['is_active'] = $getData['is_active'];
                $returnData['data']['is_verify'] = $getData['is_verify'];
            } else {
                $returnData['message'] = "Data Not Found";
                $returnData['object'] = "pro_tenantusers";
            }
            return $returnData;
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
