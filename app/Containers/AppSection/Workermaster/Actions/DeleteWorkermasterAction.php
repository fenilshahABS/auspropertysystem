<?php

namespace App\Containers\AppSection\Workermaster\Actions;

use App\Containers\AppSection\Workermaster\Tasks\DeleteWorkermasterTask;
use App\Containers\AppSection\Workermaster\UI\API\Requests\DeleteWorkermasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteWorkermasterAction extends ParentAction
{
    /**
     * @param DeleteWorkermasterRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteWorkermasterRequest $request)
    {
        return app(DeleteWorkermasterTask::class)->run($request->id);
    }
}
