<?php

namespace App\Containers\AppSection\Propertyreports\Tasks;

use App\Containers\AppSection\Propertyreports\Data\Repositories\PropertyreportsRepository;
use App\Containers\AppSection\Propertyreports\Models\Propertyreports;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreatePropertyreportsTask extends ParentTask
{
    public function __construct(
        protected PropertyreportsRepository $repository
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(array $data): Propertyreports
    {
        try {
            return $this->repository->create($data);
        } catch (Exception) {
            throw new CreateResourceFailedException();
        }
    }
}
