<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Tasks;

use App\Containers\AppSection\RentalPropertyManagement\Data\Repositories\RentalPropertyManagementRepository;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagementLateFees;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteRentalPropertyManagementTask extends ParentTask
{
    public function __construct(
        protected RentalPropertyManagementRepository $repository
    ) {
    }

    /**
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run($id)
    {
        try {
            $returnData = array();
            $delete = RentalPropertyManagementLateFees::where('id', $id)->delete($id);
            if ($delete) {
                $returnData['message'] = "Data Deleted Successfully";
            } else {
                $returnData['message'] = "Data Failed To Delete";
            }
            return $returnData;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
