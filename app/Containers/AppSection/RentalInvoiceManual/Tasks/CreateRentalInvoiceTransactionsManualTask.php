<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Tasks;

use App\Containers\AppSection\RentalInvoiceManual\Data\Repositories\RentalInvoiceManualRepository;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceTransactionsManual;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreateRentalInvoiceTransactionsManualTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceManualRepository $repository
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run($data)
    {
        try {

            $returnData = array();

            // if ($create) {
            $update = RentalInvoiceManual::where('id', $data['rental_invoice_id'])->first();
            if ($update->pending_amount  >= $data['amount']) {
                $update->pending_amount -= $data['amount'];
                $create = RentalInvoiceTransactionsManual::create($data);
                if ($create) {
                    $update->save();
                    $returnData['object'] = "pro_rentals_invoice_transactions";
                    $returnData['message'] = "Transaction Done Successfully";
                } else {
                    $returnData['message'] = "Transaction Failed";
                }
            } else {
                $returnData['message'] = "Transaction Amount Invalid";
            }
            return $returnData;
        } catch (Exception) {
            throw new CreateResourceFailedException();
        }
    }
}
