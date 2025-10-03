<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Actions;

use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Containers\AppSection\RentalInvoiceManual\Tasks\FindRentalInvoiceManualByIdTask;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\FindRentalInvoiceManualByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindRentalInvoiceManualByIdAction extends ParentAction
{
    /**
     * @throws NotFoundException
     */
    public function run(FindRentalInvoiceManualByIdRequest $request)
    {
        return app(FindRentalInvoiceManualByIdTask::class)->run($request->id);
    }
}
