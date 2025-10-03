<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Containers\AppSection\RentalInvoiceManual\Tasks\UpdateRentalInvoiceManualByFieldsTask;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\UpdateRentalInvoiceManualRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateRentalInvoiceManualByFieldsAction extends ParentAction
{
    use HashIdTrait;
    /**
     * @param UpdateRentalInvoiceManualRequest $request
     * @return RentalInvoiceManual
     * @throws UpdateResourceFailedException
     * @throws IncorrectIdException
     * @throws NotFoundException
     */
    public function run(UpdateRentalInvoiceManualRequest $request, $InputData)
    {
        $data = $request->sanitizeInput([

            "transaction_number" => $InputData->getTransactionNumber(),
            "notes" => $InputData->getNotes(),
            "transaction_date" => $InputData->getTransactionDate(),
            "status" => $InputData->getStatus(),
            "amount_type" => $InputData->getAmountType(),
        ]);
        return app(UpdateRentalInvoiceManualByFieldsTask::class)->run($data, $request->id);
    }
}
