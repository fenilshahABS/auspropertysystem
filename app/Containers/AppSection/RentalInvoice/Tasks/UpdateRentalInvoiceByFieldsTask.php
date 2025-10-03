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

class UpdateRentalInvoiceByFieldsTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($InputData, $id)
    {
        //   try {
        $returnData = array();
        $field_db = $InputData->getFieldDB();
        $search_val = $InputData->getSearchVal();

        if ($field_db == "tax") {;

            $update = RentalInvoice::where('id', $id)->first();

            $tax_amount = $update->amount_total * ($search_val / 100);
            $update->tax = $search_val;
            $update->tax_amount = $tax_amount;
            $update->save();
        } else {;

            $update = RentalInvoice::where('id', $id)->update([$field_db => $search_val]);
        }
        if ($update) {
            return $this->repository->find($id);
        } else {
            return $returnData['message'] = "Failed To Update";
        }
        return $returnData;
        // } catch (ModelNotFoundException) {
        //     throw new NotFoundException();
        // } catch (Exception) {
        //     throw new UpdateResourceFailedException();
        // }
    }
}
