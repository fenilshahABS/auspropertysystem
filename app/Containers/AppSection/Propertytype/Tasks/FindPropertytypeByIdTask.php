<?php

namespace App\Containers\AppSection\Propertytype\Tasks;

use App\Containers\AppSection\Propertytype\Data\Repositories\PropertytypeRepository;
use App\Containers\AppSection\Propertytype\Models\Propertytype;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class FindPropertytypeByIdTask extends ParentTask
{
    public function __construct(
        protected PropertytypeRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function run($id)
    {
        try {
            return $this->repository->find($id);
        } catch (Exception) {
            throw new NotFoundException();
        }
    }
}
