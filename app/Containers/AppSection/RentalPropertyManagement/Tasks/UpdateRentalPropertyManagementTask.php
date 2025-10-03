<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Tasks;

use App\Containers\AppSection\RentalPropertyManagement\Data\Repositories\RentalPropertyManagementRepository;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagementLateFees;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateRentalPropertyManagementTask extends ParentTask
{
    public function __construct(
        protected RentalPropertyManagementRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run(array $data, $id, $fees_details)
    {
        try {
            $update = $this->repository->update($data, $id);

            for ($i = 0; $i < count($fees_details); $i++) {
                if (isset($fees_details[$i]['id'])) {
                    $upadte_master_details = RentalPropertyManagementLateFees::where('id', $fees_details[$i]['id'])->update($fees_details[$i]);
                } else {
                    $fees_details[$i]['pro_rentals_property_management_id'] = $id;

                    $upadte_master_details = RentalPropertyManagementLateFees::create($fees_details[$i]);
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
