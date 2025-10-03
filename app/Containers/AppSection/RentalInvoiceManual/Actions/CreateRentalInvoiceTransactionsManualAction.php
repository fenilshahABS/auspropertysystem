<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Containers\AppSection\RentalInvoiceManual\Tasks\CreateRentalInvoiceTransactionsManualTask;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\CreateRentalInvoiceManualRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Carbon\Carbon;

class CreateRentalInvoiceTransactionsManualAction extends ParentAction
{
    use HashIdTrait;

    public function run(CreateRentalInvoiceManualRequest $request, $InputData)
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

        return app(CreateRentalInvoiceTransactionsManualTask::class)->run($data);
    }
}
