<?php

namespace App\Containers\AppSection\RentalInvoice\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\RentalInvoice\Tasks\GetAllRentalInvoicesPaginationTask;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\GetAllRentalInvoicesRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalInvoicesPaginationAction extends ParentAction
{

    public function run(GetAllRentalInvoicesRequest $request, $InputData)
    {
        return app(GetAllRentalInvoicesPaginationTask::class)->run($InputData, $request);
    }
}
