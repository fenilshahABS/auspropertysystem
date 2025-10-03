<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Tasks\UpdateRentalInvoiceManualByFieldsPropertyTask;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Requests\UpdateRentalInvoiceManualPropertyRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateRentalInvoiceManualByFieldsPropertyAction extends ParentAction
{
    use HashIdTrait;
    /**
     * @param UpdateRentalInvoiceManualPropertyRequest $request
     * @return RentalInvoiceManual
     * @throws UpdateResourceFailedException
     * @throws IncorrectIdException
     * @throws NotFoundException
     */
    public function run(UpdateRentalInvoiceManualPropertyRequest $request, $InputData)
    {
        $data = $request->sanitizeInput([

            "transaction_number" => $InputData->getTransactionNumber(),
            "notes" => $InputData->getNotes(),
            "transaction_date" => $InputData->getTransactionDate(),
            "status" => $InputData->getStatus(),
            "amount_type" => $InputData->getAmountType(),
        ]);
        return app(UpdateRentalInvoiceManualByFieldsPropertyTask::class)->run($data, $request->id);
    }
}
