<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Actions;

use App\Containers\AppSection\RentalInvoiceManual\Tasks\DeleteRentalInvoiceManualTask;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\DeleteRentalInvoiceManualRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteRentalInvoiceManualAction extends ParentAction
{
    /**
     * @param DeleteRentalInvoiceManualRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteRentalInvoiceManualRequest $request)
    {
        return app(DeleteRentalInvoiceManualTask::class)->run($request->id);
    }
}
