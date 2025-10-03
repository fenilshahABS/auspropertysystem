<?php

namespace App\Containers\AppSection\TaskManagement\Tasks;

use App\Containers\AppSection\TaskManagement\Data\Repositories\TaskManagementRepository;
use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreateTaskManagementTask extends ParentTask
{
    public function __construct(
        protected TaskManagementRepository $repository
    ) {
    }


    public function run(array $data)
    {
        //try {
        return $this->repository->create($data);
        // } catch (Exception) {
        //     throw new CreateResourceFailedException();
        // }
    }
}
