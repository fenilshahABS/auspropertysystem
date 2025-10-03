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

class UpdateRentalInvoiceLateFeesTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($data, $id)
    {
        try {

            $returnData = array();

            $getRentalInvoiceChild = RentalInvoiceChild::where('id', $id)->first();
            $update = "";
            if (!empty($getRentalInvoiceChild)) {
                $updateRentalInvoice = RentalInvoice::where('id', $getRentalInvoiceChild->rent_invoice_id)->first();
                if ($data['amount'] > $getRentalInvoiceChild->amount) {

                    $amount_to_add = (int)$data['amount'] - (int)$getRentalInvoiceChild->amount;
                    $updateRentalInvoice->amount_total += (int) $amount_to_add;
                    $updateRentalInvoice->pending_amount += (int) $amount_to_add;
                    $updateRentalInvoice->save();
                    $update = RentalInvoiceChild::where('id', $id)->update($data);
                } elseif ($data['amount'] < $getRentalInvoiceChild->amount) {
                    $amount_to_sub =  $getRentalInvoiceChild->amount - $data['amount'];
                    if ($updateRentalInvoice->pending_amount >= $amount_to_sub) {
                        $updateRentalInvoice->amount_total -= (int)$amount_to_sub;
                        $updateRentalInvoice->pending_amount -= (int)$amount_to_sub;
                        $updateRentalInvoice->save();
                        $update = RentalInvoiceChild::where('id', $id)->update($data);
                    }
                } elseif ($data['amount'] == $getRentalInvoiceChild->amount) {
                    $update = RentalInvoiceChild::where('id', $id)->update($data);
                }

                if ($update) {
                    $returnData['message'] = "Updated Successfully";
                } else {
                    $returnData['message'] = "Failed To Update";
                }
            } else {
                $returnData['message'] = "Data Not Found";
            }
            return $returnData;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
