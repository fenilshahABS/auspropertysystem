<?php

namespace App\Containers\AppSection\RentalInvoice\Actions;

use App\Containers\AppSection\RentalInvoice\Tasks\DeleteRentalInvoiceLateFeesTask;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\DeleteRentalInvoiceRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteRentalInvoiceLateFeesAction extends ParentAction
{
    /**
     * @param DeleteRentalInvoiceRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteRentalInvoiceRequest $request)
    {
        return app(DeleteRentalInvoiceLateFeesTask::class)->run($request->id);
    }
}
