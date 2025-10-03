<?php

namespace App\Containers\AppSection\Workermaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Workermaster\Tasks\GetAllWorkermastersTask;
use App\Containers\AppSection\Workermaster\UI\API\Requests\GetAllWorkermastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllWorkermastersAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllWorkermastersRequest $request)
    {
        return app(GetAllWorkermastersTask::class)->run();
    }
}
