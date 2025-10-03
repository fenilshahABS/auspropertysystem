<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Tasks;

use App\Containers\AppSection\RentalInvoiceManualProperty\Data\Repositories\RentalInvoiceManualPropertyRepository;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualDetailsProperty;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteRentalInvoiceManualPropertyTask extends ParentTask
{
    public function __construct(
        protected RentalInvoiceManualPropertyRepository $repository
    ) {
    }


    public function run($id)
    {
        try {


            $delete_service_data = RentalInvoiceManualDetailsProperty::where('id', $id)->delete();
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
