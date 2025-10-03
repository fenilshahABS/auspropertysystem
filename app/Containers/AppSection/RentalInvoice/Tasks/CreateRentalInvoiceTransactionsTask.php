<?php

namespace App\Containers\AppSection\RentalInvoice\Tasks;

use App\Containers\AppSection\RentalInvoice\Data\Repositories\RentalInvoiceRepository;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoiceTransactions;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreateRentalInvoiceTransactionsTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceRepository $repository
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
            $update = RentalInvoice::where('id', $data['rental_invoice_id'])->first();
            if ($update->pending_amount  >= $data['amount']) {
                $update->pending_amount -= $data['amount'];
                $create = RentalInvoiceTransactions::create($data);
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
