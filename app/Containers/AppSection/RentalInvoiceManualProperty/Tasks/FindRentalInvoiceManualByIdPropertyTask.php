<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Tasks;

use App\Containers\AppSection\RentalInvoiceManualProperty\Data\Repositories\RentalInvoiceManualPropertyRepository;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class FindRentalInvoiceManualByIdPropertyTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceManualPropertyRepository $repository
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
