<?php

namespace App\Containers\AppSection\Propertymaster\Tasks;

use App\Containers\AppSection\Propertymaster\Data\Repositories\PropertymasterRepository;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeletePropertyShareDetailsTask extends ParentTask
{
    public function __construct(
        protected PropertymasterRepository $repository
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
            $delete_share_details = PropertymasterShareDetails::where('id', $id)->delete();
            if ($delete_share_details) {
                $returnData['message'] = "Data deleted Successfully";
            } else {
                $returnData['message'] = "Failed to Delete";
            }
            return $returnData;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
