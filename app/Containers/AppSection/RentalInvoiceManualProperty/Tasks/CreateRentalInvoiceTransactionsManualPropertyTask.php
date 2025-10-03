<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Tasks;

use App\Containers\AppSection\RentalInvoiceManualProperty\Data\Repositories\RentalInvoiceManualPropertyRepository;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceTransactionsManualProperty;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreateRentalInvoiceTransactionsManualPropertyTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceManualPropertyRepository $repository
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
            $update = RentalInvoiceManualProperty::where('id', $data['rental_invoice_id'])->first();
            if ($update->pending_amount  >= $data['amount']) {
                $update->pending_amount -= $data['amount'];
                $create = RentalInvoiceTransactionsManualProperty::create($data);
                if ($create) {
                    $update->save();
                    $returnData['object'] = "pro_rentals_invoice_transactions_manual_property";
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
