<?php

namespace App\Containers\AppSection\Propertymaster\Tasks;

use App\Containers\AppSection\Propertymaster\Data\Repositories\PropertymasterRepository;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdatePropertymasterTask extends ParentTask
{
    public function __construct(
        protected PropertymasterRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($data, $id, $master_details, $share_details)
    {
        try {
            $update = $this->repository->update($data, $id);

            if (isset($master_details) && !empty($master_details)) {
                for ($i = 0; $i < count($master_details); $i++) {
                    if (isset($master_details[$i]['id'])) {
                        $upadte_master_details = PropertymasterDetails::where('id', $master_details[$i]['id'])->update($master_details[$i]);
                    } else {
                        $master_details[$i]['pro_property_master_id'] = $id;
                        $upadte_master_details = PropertymasterDetails::create($master_details[$i]);
                    }
                }
            }
            if (isset($share_details) && !empty($share_details)) {
                for ($i = 0; $i < count($share_details); $i++) {
                    if (isset($share_details[$i]['id'])) {
                        $upadte_share_details = PropertymasterShareDetails::where('id', $share_details[$i]['id'])->update($share_details[$i]);
                    } else {
                        $share_details[$i]['pro_property_master_id'] = $id;
                        $upadte_share_details = PropertymasterShareDetails::create($share_details[$i]);
                    }
                }
            }


            return $update;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
