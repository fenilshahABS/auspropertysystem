<?php

namespace App\Containers\AppSection\RentalInvoice\Actions;

use App\Containers\AppSection\RentalInvoice\Tasks\DeleteRentalInvoiceTask;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\DeleteRentalInvoiceRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteRentalInvoiceAction extends ParentAction
{
    /**
     * @param DeleteRentalInvoiceRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteRentalInvoiceRequest $request): int
    {
        return app(DeleteRentalInvoiceTask::class)->run($request->id);
    }
}
