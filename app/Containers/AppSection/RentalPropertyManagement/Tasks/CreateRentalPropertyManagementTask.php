<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Tasks;

use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\RentalPropertyManagement\Data\Repositories\RentalPropertyManagementRepository;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagementLateFees;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreateRentalPropertyManagementTask extends ParentTask
{
    public function __construct(
        protected RentalPropertyManagementRepository $repository
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run($data, $fees_details)
    {
        try {
            $create_rental_property = $this->repository->create($data);
            $update_rental_property_details = PropertymasterDetails::where('id', $create_rental_property->pro_property_master_details_id)->update(["property_status" => 2]);
            if (!empty($fees_details)) {
                for ($i = 0; $i < count($fees_details); $i++) {
                    $fees_details[$i]['pro_rentals_property_management_id'] = $create_rental_property->id;
                    $create_rental_property_late_fees = RentalPropertyManagementLateFees::create($fees_details[$i]);
                }
            }

            return $create_rental_property;
        } catch (Exception) {
            throw new CreateResourceFailedException();
        }
    }
}
