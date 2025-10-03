<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\RentalInvoiceManualProperty\Tasks\GetAllRentalInvoiceManualsPropertyTask;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Requests\GetAllRentalInvoiceManualsPropertyRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalInvoiceManualsPropertyAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllRentalInvoiceManualsPropertyRequest $request, $InputData)
    {

        return app(GetAllRentalInvoiceManualsPropertyTask::class)->run($InputData, $request);
    }
}
