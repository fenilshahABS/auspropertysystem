<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Tasks;

use App\Containers\AppSection\RentalPropertyManagement\Data\Repositories\RentalPropertyManagementRepository;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class FindRentalPropertyManagementByIdTask extends ParentTask
{
    public function __construct(
        protected RentalPropertyManagementRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function run($id)
    {
        try {
            return $this->repository->find($id);
        } catch (Exception) {
            throw new NotFoundException();
        }
    }
}
