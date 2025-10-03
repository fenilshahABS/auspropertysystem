<?php

namespace App\Containers\AppSection\Propertyreports\Tasks;

use App\Containers\AppSection\Propertyreports\Data\Repositories\PropertyreportsRepository;
use App\Containers\AppSection\Propertyreports\Models\Propertyreports;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class FindPropertyreportsByIdTask extends ParentTask
{
    public function __construct(
        protected PropertyreportsRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function run($id): Propertyreports
    {
        try {
            return $this->repository->find($id);
        } catch (Exception) {
            throw new NotFoundException();
        }
    }
}
