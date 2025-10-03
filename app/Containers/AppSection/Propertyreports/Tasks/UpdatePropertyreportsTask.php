<?php

namespace App\Containers\AppSection\Propertyreports\Tasks;

use App\Containers\AppSection\Propertyreports\Data\Repositories\PropertyreportsRepository;
use App\Containers\AppSection\Propertyreports\Models\Propertyreports;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdatePropertyreportsTask extends ParentTask
{
    public function __construct(
        protected PropertyreportsRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run(array $data, $id): Propertyreports
    {
        try {
            return $this->repository->update($data, $id);
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
