<?php

namespace App\Containers\AppSection\Workermaster\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Containers\AppSection\Workermaster\Tasks\UpdateWorkermasterByFieldsTask;
use App\Containers\AppSection\Workermaster\UI\API\Requests\UpdateWorkermasterRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateWorkermasterByFieldsAction extends ParentAction
{
    /**
     * @param UpdateWorkermasterRequest $request
     * @return Workermaster
     * @throws UpdateResourceFailedException
     * @throws IncorrectIdException
     * @throws NotFoundException
     */
    public function run(UpdateWorkermasterRequest $request, $InputData)
    {
        return app(UpdateWorkermasterByFieldsTask::class)->run($request->id, $InputData);
    }
}
