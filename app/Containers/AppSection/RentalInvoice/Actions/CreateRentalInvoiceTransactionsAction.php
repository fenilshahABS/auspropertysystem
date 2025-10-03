<?php

namespace App\Containers\AppSection\RentalInvoice\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Tasks\CreateRentalInvoiceTransactionsTask;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\CreateRentalInvoiceRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Carbon\Carbon;

class CreateRentalInvoiceTransactionsAction extends ParentAction
{
    use HashIdTrait;
    /**
     * @param CreateRentalInvoiceRequest $request
     * @return RentalInvoice
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(CreateRentalInvoiceRequest $request, $InputData)
    {
        $transaction_date = date('Y-m-d');
        if(!empty($InputData->getTransactionsDate())){
          $transaction_date = Carbon::parse($InputData->getTransactionsDate())->format('Y-m-d');
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

        return app(CreateRentalInvoiceTransactionsTask::class)->run($data);
    }
}
