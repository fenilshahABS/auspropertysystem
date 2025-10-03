<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Tasks;

use App\Containers\AppSection\RentalInvoiceManual\Data\Repositories\RentalInvoiceManualRepository;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManualDetails;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CheckInvoiceNumberTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceManualRepository $repository
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run($InputData)
    {
        //       try {
        $invoice_number = $InputData->getInvoiceNumber();

        $check_invoice_number = RentalInvoiceManual::where('invoice_number', $invoice_number)->count();
        if ($check_invoice_number == 0) {
            $returnData['status'] = "success";
        } else {
            $returnData['status'] = "fail";
        }
        return $returnData;
        // } catch (Exception) {
        //     throw new CreateResourceFailedException();
        // }
    }
}
