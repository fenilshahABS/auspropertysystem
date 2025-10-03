<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Actions;

use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Tasks\FindRentalInvoiceManualByIdPropertyTask;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Requests\FindRentalInvoiceManualPropertyByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindRentalInvoiceManualByIdPropertyAction extends ParentAction
{
    /**
     * @throws NotFoundException
     */
    public function run(FindRentalInvoiceManualPropertyByIdRequest $request)
    {
        return app(FindRentalInvoiceManualByIdPropertyTask::class)->run($request->id);
    }
}
