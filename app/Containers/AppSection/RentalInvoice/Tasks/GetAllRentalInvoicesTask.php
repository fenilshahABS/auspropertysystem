<?php

namespace App\Containers\AppSection\RentalInvoice\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\RentalInvoice\Data\Repositories\RentalInvoiceRepository;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalInvoicesTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceRepository $repository
    ) {
    }

    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(): mixed
    {
        return $this->addRequestCriteria()->repository->paginate();
    }
}
