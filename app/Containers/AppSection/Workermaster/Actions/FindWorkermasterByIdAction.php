<?php

namespace App\Containers\AppSection\Workermaster\Actions;

use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Containers\AppSection\Workermaster\Tasks\FindWorkermasterByIdTask;
use App\Containers\AppSection\Workermaster\UI\API\Requests\FindWorkermasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindWorkermasterByIdAction extends ParentAction
{
    /**
     * @throws NotFoundException
     */
    public function run(FindWorkermasterByIdRequest $request)
    {
        return app(FindWorkermasterByIdTask::class)->run($request->id);
    }
}
