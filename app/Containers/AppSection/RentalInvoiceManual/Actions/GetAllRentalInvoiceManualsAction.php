<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\RentalInvoiceManual\Tasks\GetAllRentalInvoiceManualsTask;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\GetAllRentalInvoiceManualsRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalInvoiceManualsAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllRentalInvoiceManualsRequest $request, $InputData)
    {

        return app(GetAllRentalInvoiceManualsTask::class)->run($InputData, $request);
    }
}
