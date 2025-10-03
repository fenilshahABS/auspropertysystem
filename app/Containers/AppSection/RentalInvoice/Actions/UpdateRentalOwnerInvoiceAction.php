<?php

namespace App\Containers\AppSection\RentalInvoice\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Tasks\UpdateRentalOwnerInvoiceTask;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\UpdateRentalInvoiceRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateRentalOwnerInvoiceAction extends ParentAction
{

    public function run(UpdateRentalInvoiceRequest $request, $InputData)
    {
        $data = $request->sanitizeInput([
            "status" => $InputData->getStatus(),
            "transaction_number" => $InputData->getTransactionNumber(),
            "notes" => $InputData->getNotes(),
            "transaction_date" => date('y-m-d')
        ]);

        return app(UpdateRentalOwnerInvoiceTask::class)->run($data, $request->id);
    }
}
