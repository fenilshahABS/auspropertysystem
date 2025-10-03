<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Tasks;

use App\Containers\AppSection\RentalInvoiceManualProperty\Data\Repositories\RentalInvoiceManualPropertyRepository;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualDetailsProperty;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateRentalInvoiceManualPropertyTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceManualPropertyRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($data, $id, $rent_invoice_details)
    {
        try {
            $update = $this->repository->update($data, $id);

            for ($i = 0; $i < count($rent_invoice_details); $i++) {
                if (isset($rent_invoice_details[$i]['id'])) {
                    $update_invoice_details = RentalInvoiceManualDetailsProperty::where('id', $rent_invoice_details[$i]['id'])->update($rent_invoice_details[$i]);
                } else {
                    $rent_invoice_details[$i]['rent_invoice_id'] = $id;
                    $update_invoice_details = RentalInvoiceManualDetailsProperty::create($rent_invoice_details[$i]);
                }
            }
            return $update;
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
