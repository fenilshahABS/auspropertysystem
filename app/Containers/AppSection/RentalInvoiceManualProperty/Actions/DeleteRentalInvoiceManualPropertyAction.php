<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Actions;

use App\Containers\AppSection\RentalInvoiceManualProperty\Tasks\DeleteRentalInvoiceManualPropertyTask;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Requests\DeleteRentalInvoiceManualPropertyRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteRentalInvoiceManualPropertyAction extends ParentAction
{
    /**
     * @param DeleteRentalInvoiceManualPropertyRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteRentalInvoiceManualPropertyRequest $request)
    {
        return app(DeleteRentalInvoiceManualPropertyTask::class)->run($request->id);
    }
}
