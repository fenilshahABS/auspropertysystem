<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Tasks;

use App\Containers\AppSection\RentalInvoiceManual\Data\Repositories\RentalInvoiceManualRepository;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManualDetails;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteRentalInvoiceManualTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceManualRepository $repository
    ) {
    }


    public function run($id)
    {
        try {


            $delete_service_data = RentalInvoiceManualDetails::where('id', $id)->delete();
            $returnData = array();
            if ($delete_service_data) {
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
