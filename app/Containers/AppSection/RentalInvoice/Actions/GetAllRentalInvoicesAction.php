<?php

namespace App\Containers\AppSection\RentalInvoice\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\RentalInvoice\Tasks\GetAllRentalInvoicesTask;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\GetAllRentalInvoicesRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalInvoicesAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllRentalInvoicesRequest $request): mixed
    {
        return app(GetAllRentalInvoicesTask::class)->run();
    }
}
