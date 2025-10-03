<?php

namespace App\Containers\AppSection\Workermaster\Tasks;

use App\Containers\AppSection\Workermaster\Data\Repositories\WorkermasterRepository;
use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateWorkermasterByFieldsTask extends ParentTask
{
    public function __construct(
        protected WorkermasterRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($id, $InputData)
    {
        try {
          $returnData = array();
            $is_field = $InputData->getFieldDB();
            $value = $InputData->getSearchVal();
            $update = Workermaster::where('id', $id)->update([$is_field => $value]);
            if ($update) {
                $returnData['message'] = "Data Updated Succesfully";
            } else {
                $returnData['message'] = "Failed to update";
            }
            return $returnData;
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
