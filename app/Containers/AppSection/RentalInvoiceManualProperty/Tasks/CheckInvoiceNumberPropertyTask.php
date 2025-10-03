<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Tasks;

use App\Containers\AppSection\RentalInvoiceManualProperty\Data\Repositories\RentalInvoiceManualPropertyRepository;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualDetailsProperty;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CheckInvoiceNumberPropertyTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceManualPropertyRepository $repository
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run($InputData)
    {
        //       try {
        $invoice_number = $InputData->getInvoiceNumber();

        $check_invoice_number = RentalInvoiceManualProperty::where('invoice_number', $invoice_number)->count();
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
