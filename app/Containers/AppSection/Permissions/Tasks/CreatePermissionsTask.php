<?php

namespace App\Containers\AppSection\Permissions\Tasks;

use App\Containers\AppSection\Permissions\Data\Repositories\PermissionsRepository;
use App\Containers\AppSection\Permissions\Models\Permissions;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreatePermissionsTask extends ParentTask
{
    public function __construct(
        protected PermissionsRepository $repository
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(array $data): Permissions
    {
        try {
            return $this->repository->create($data);
        } catch (Exception) {
            throw new CreateResourceFailedException();
        }
    }
}
