<?php

namespace App\Containers\AppSection\RentalInvoice\Tasks;

use App\Containers\AppSection\RentalInvoice\Data\Repositories\RentalInvoiceRepository;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoiceChild;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateRentalInvoiceTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run(array $data, $id)
    {
        try {
            $returnData = array();
            $update = RentalInvoice::where('id', $id)->update($data);
            if ($update) {
                $updateInvoiceDetails = RentalInvoiceChild::where('rent_invoice_id', $id)->update(['status' => $data['status']]);
                $returnData['message'] = "Updated Successfully";
            } else {
                $returnData['message'] = "Failed To Update";
            }
            return $returnData;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
