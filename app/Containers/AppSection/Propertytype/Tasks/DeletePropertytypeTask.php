<?php

namespace App\Containers\AppSection\Propertytype\Tasks;

use App\Containers\AppSection\Propertytype\Data\Repositories\PropertytypeRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeletePropertytypeTask extends ParentTask
{
    public function __construct(
        protected PropertytypeRepository $repository
    ) {
    }

    /**
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run($id): int
    {
        try {

            $delete = $this->repository->delete($id);
            $returnData = array();
            if ($delete) {
                $returnData['message'] = "Data deleted Succesfully";
            } else {
                $returnData['message'] = "Failed to delete";
            }
            return $returnData;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
