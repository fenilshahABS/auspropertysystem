<?php

namespace App\Containers\AppSection\Dashboard\Tasks;

use App\Containers\AppSection\Dashboard\Data\Repositories\DashboardRepository;
use App\Containers\AppSection\Dashboard\Models\Dashboard;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class FindDashboardByIdTask extends ParentTask
{
    public function __construct(
        protected DashboardRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function run($id): Dashboard
    {
        try {
            return $this->repository->find($id);
        } catch (Exception) {
            throw new NotFoundException();
        }
    }
}
