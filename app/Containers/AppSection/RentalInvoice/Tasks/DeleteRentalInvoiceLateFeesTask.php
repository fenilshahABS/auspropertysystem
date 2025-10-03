<?php

namespace App\Containers\AppSection\RentalInvoice\Tasks;

use App\Containers\AppSection\RentalInvoice\Data\Repositories\RentalInvoiceRepository;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoiceChild;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteRentalInvoiceLateFeesTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceRepository $repository
    ) {
    }

    /**
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run($id)
    {
        try {
            $getRentalInvoiceChild = RentalInvoiceChild::where('id', $id)->first();

            $delete_late_fees_data = "";
            if (!empty($getRentalInvoiceChild)) {
                $updateRentalInvoice = RentalInvoice::where('id', $getRentalInvoiceChild->rent_invoice_id)->first();
                if ($updateRentalInvoice->pending_amount >= $getRentalInvoiceChild->amount) {
                    $updateRentalInvoice->amount_total -= $getRentalInvoiceChild->amount;
                    $updateRentalInvoice->pending_amount -= $getRentalInvoiceChild->amount;
                    $updateRentalInvoice->save();
                    $delete_late_fees_data = RentalInvoiceChild::where('id', $id)->delete();
                }
            }
            $returnData = array();
            if ($delete_late_fees_data) {
                $returnData['message'] = "Data Deleted Successfully";
            } else {
                $returnData['message'] = "Failed To Delete";
            }
            return $returnData;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
