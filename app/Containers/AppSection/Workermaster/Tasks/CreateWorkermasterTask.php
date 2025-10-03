<?php

namespace App\Containers\AppSection\Workermaster\Tasks;

use App\Containers\AppSection\Workermaster\Data\Repositories\WorkermasterRepository;
use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreateWorkermasterTask extends ParentTask
{
    public function __construct(
        protected WorkermasterRepository $repository
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
