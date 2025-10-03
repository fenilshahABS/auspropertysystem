<?php

namespace App\Containers\AppSection\Realtimechat\Tasks;

use App\Containers\AppSection\Realtimechat\Data\Repositories\RealtimechatRepository;
use App\Containers\AppSection\Realtimechat\Models\Realtimechat;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class CreateRealtimechatTask extends ParentTask
{
    public function __construct(
        protected RealtimechatRepository $repository
    ) {
    }


    public function run(array $data)
    {
        // try {
        return $this->repository->create($data);
        // } catch (Exception) {
        //     throw new CreateResourceFailedException();
        // }
    }
}
