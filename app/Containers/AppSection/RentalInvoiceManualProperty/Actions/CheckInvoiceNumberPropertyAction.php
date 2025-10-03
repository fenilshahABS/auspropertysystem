<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Tasks\CheckInvoiceNumberPropertyTask;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Requests\CreateRentalInvoiceManualPropertyRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CheckInvoiceNumberPropertyAction extends ParentAction
{
    use HashIdTrait;

    public function run(CreateRentalInvoiceManualPropertyRequest $request, $InputData)
    {

        return app(CheckInvoiceNumberPropertyTask::class)->run($InputData);
    }
}
