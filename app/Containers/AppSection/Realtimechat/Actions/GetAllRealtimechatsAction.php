<?php

namespace App\Containers\AppSection\Realtimechat\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Realtimechat\Tasks\GetAllRealtimechatsTask;
use App\Containers\AppSection\Realtimechat\UI\API\Requests\GetAllRealtimechatsRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRealtimechatsAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllRealtimechatsRequest $request, $InputData)
    {
        return app(GetAllRealtimechatsTask::class)->run($InputData);
    }
}
