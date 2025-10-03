<?php

namespace App\Containers\AppSection\RentalInvoice\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Tasks\CreateRentalInvoiceTask;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\CreateRentalInvoiceRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateRentalInvoiceAction extends ParentAction
{
    /**
     * @param CreateRentalInvoiceRequest $request
     * @return RentalInvoice
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(CreateRentalInvoiceRequest $request): RentalInvoice
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        return app(CreateRentalInvoiceTask::class)->run($data);
    }
}
