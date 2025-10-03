<?php

namespace App\Containers\AppSection\Workermaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Workermaster\Tasks\GetAllWorkermastersBySearchTask;
use App\Containers\AppSection\Workermaster\UI\API\Requests\GetAllWorkermastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllWorkermastersBySearchAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllWorkermastersRequest $request, $InputData)
    {
        return app(GetAllWorkermastersBySearchTask::class)->run($InputData);
    }
}
