<?php

namespace App\Containers\AppSection\Tenantusers\Tasks;

use App\Containers\AppSection\Tenantusers\Data\Repositories\TenantusersRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteTenantusersTask extends Task
{
    protected TenantusersRepository $repository;

    public function __construct(TenantusersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {
            $delete = $this->repository->delete($id);
            $returnData['message'] = "Data Deleted Successfully";
            return $returnData;
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
