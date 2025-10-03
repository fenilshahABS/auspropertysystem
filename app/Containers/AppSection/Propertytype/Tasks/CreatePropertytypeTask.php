<?php

namespace App\Containers\AppSection\Propertytype\Tasks;

use App\Containers\AppSection\Propertytype\Data\Repositories\PropertytypeRepository;
use App\Containers\AppSection\Propertytype\Models\Propertytype;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreatePropertytypeTask extends ParentTask
{
    public function __construct(
        protected PropertytypeRepository $repository
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (Exception) {
            throw new CreateResourceFailedException();
        }
    }
}
