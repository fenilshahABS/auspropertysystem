<?php

namespace App\Containers\AppSection\RentalInvoice\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Tasks\UpdateRentalInvoiceLateFeesTask;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\UpdateRentalInvoiceRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateRentalInvoiceLateFeesAction extends ParentAction
{

    public function run(UpdateRentalInvoiceRequest $request, $InputData)
    {
        $data = $request->sanitizeInput([
            "amount" => $InputData->getAmount(),
            "description" => $InputData->getDescription(),
            "status" => $InputData->getStatus(),
        ]);

        return app(UpdateRentalInvoiceLateFeesTask::class)->run($data, $request->id);
    }
}
