<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Tasks;

use App\Containers\AppSection\RentalInvoiceManual\Data\Repositories\RentalInvoiceManualRepository;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManualDetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateRentalInvoiceManualTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceManualRepository $repository
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
                    $update_invoice_details = RentalInvoiceManualDetails::where('id', $rent_invoice_details[$i]['id'])->update($rent_invoice_details[$i]);
                } else {
                    $rent_invoice_details[$i]['rent_invoice_id'] = $id;
                    $update_invoice_details = RentalInvoiceManualDetails::create($rent_invoice_details[$i]);
                }
            }
            return $update;
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
