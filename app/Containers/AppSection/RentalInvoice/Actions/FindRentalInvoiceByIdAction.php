<?php

namespace App\Containers\AppSection\RentalInvoice\Actions;

use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Tasks\FindRentalInvoiceByIdTask;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\FindRentalInvoiceByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindRentalInvoiceByIdAction extends ParentAction
{
    /**
     * @throws NotFoundException
     */
    public function run(FindRentalInvoiceByIdRequest $request)
    {
        return app(FindRentalInvoiceByIdTask::class)->run($request->id);
    }
}
