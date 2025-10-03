<?php

namespace App\Containers\AppSection\Workermaster\Tasks;

use App\Containers\AppSection\Workermaster\Data\Repositories\WorkermasterRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteWorkermasterTask extends ParentTask
{
    public function __construct(
        protected WorkermasterRepository $repository
    ) {
    }

    /**
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run($id)
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
