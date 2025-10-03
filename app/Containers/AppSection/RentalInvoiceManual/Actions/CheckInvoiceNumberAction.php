<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Containers\AppSection\RentalInvoiceManual\Tasks\CheckInvoiceNumberTask;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\CreateRentalInvoiceManualRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CheckInvoiceNumberAction extends ParentAction
{
    use HashIdTrait;

    public function run(CreateRentalInvoiceManualRequest $request, $InputData)
    {

        return app(CheckInvoiceNumberTask::class)->run($InputData);
    }
}
