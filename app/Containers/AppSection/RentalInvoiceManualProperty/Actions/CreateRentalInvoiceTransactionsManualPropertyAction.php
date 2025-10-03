<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Tasks\CreateRentalInvoiceTransactionsManualPropertyTask;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Requests\CreateRentalInvoiceManualPropertyRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Carbon\Carbon;

class CreateRentalInvoiceTransactionsManualPropertyAction extends ParentAction
{
    use HashIdTrait;

    public function run(CreateRentalInvoiceManualPropertyRequest $request, $InputData)
    {
        $transaction_date = date('Y-m-d');
        if(!empty($InputData->getTransactionDate())){
          $transaction_date = Carbon::parse($InputData->getTransactionDate())->format('Y-m-d');
        }
        $data = $request->sanitizeInput([
            "amount_type" => $InputData->getAmountType(),
            "amount" => $InputData->getAmount(),
            "status" => $InputData->getStatus(),
            "transaction_number" => $InputData->getTransactionNumber(),
            "notes" => $InputData->getNotes(),
            "transaction_date" => $transaction_date
        ]);
        $data['rental_invoice_id'] = $this->decode($InputData->getRentalInvoiceId());

        return app(CreateRentalInvoiceTransactionsManualPropertyTask::class)->run($data);
    }
}
