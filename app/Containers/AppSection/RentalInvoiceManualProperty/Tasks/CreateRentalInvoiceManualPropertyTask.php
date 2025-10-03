<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Tasks;

use App\Containers\AppSection\RentalInvoiceManualProperty\Data\Repositories\RentalInvoiceManualPropertyRepository;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualDetailsProperty;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreateRentalInvoiceManualPropertyTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceManualPropertyRepository $repository
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
            $create_rent_invoice_details = RentalInvoiceManualDetailsProperty::create($rent_invoice_details[$i]);
        }
        return $create_invoice;
        // } catch (Exception) {
        //     throw new CreateResourceFailedException();
        // }
    }
}
