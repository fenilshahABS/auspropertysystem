<?php

namespace App\Containers\AppSection\Propertymaster\Tasks;

use App\Containers\AppSection\Propertymaster\Data\Repositories\PropertymasterRepository;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use App\Ship\Parents\Absoluteweb\AbsolutewebRepository;
use Illuminate\Support\Facades\Auth;

class CreatePropertymasterTask extends ParentTask
{
    public function __construct(
        protected PropertymasterRepository $repository
    ) {
    }


    public function run($data, $master_details, $share_details)
    {
        try {
            $create_property_master = $this->repository->create($data);

            for ($i = 0; $i < count($master_details); $i++) {
                $master_details[$i]['pro_property_master_id'] = $create_property_master->id;
                $create_property_master_details = PropertymasterDetails::create($master_details[$i]);
            }
            for ($i = 0; $i < count($share_details); $i++) {
                $share_details[$i]['pro_property_master_id'] = $create_property_master->id;

                $create_property_share_details = PropertymasterShareDetails::create($share_details[$i]);
            }

            $getData = Auth::user();
            if ($getData->role_id != 1) {
                $sendWelcomeNotification = AbsolutewebRepository::sendPropertyNotification($getData);
            }

            return $create_property_master;
        } catch (Exception) {
            throw new CreateResourceFailedException();
        }
    }
}
