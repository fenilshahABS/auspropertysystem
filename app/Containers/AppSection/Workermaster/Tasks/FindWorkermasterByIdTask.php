<?php

namespace App\Containers\AppSection\Workermaster\Tasks;

use App\Containers\AppSection\Workermaster\Data\Repositories\WorkermasterRepository;
use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class FindWorkermasterByIdTask extends ParentTask
{
    public function __construct(
        protected WorkermasterRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function run($id): Workermaster
    {
        try {
            return $this->repository->find($id);
        } catch (Exception) {
            throw new NotFoundException();
        }
    }
}
