<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Tasks;

use App\Containers\AppSection\RentalInvoiceManual\Data\Repositories\RentalInvoiceManualRepository;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class FindRentalInvoiceManualByIdTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceManualRepository $repository
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
