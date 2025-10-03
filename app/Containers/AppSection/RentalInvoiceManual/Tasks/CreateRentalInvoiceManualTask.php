<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Tasks;

use App\Containers\AppSection\RentalInvoiceManual\Data\Repositories\RentalInvoiceManualRepository;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManualDetails;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreateRentalInvoiceManualTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceManualRepository $repository
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run($data, $rent_invoice_details)
    {
        //       try {

        $create_invoice = $this->repository->create($data);
        for ($i = 0; $i < count($rent_invoice_details); $i++) {
            $rent_invoice_details[$i]['rent_invoice_id'] = $create_invoice->id;
            $create_rent_invoice_details = RentalInvoiceManualDetails::create($rent_invoice_details[$i]);
        }
        return $create_invoice;
        // } catch (Exception) {
        //     throw new CreateResourceFailedException();
        // }
    }
}
