<?php

namespace App\Containers\AppSection\Rolemaster\Actions;

use App\Containers\AppSection\Rolemaster\Tasks\DeleteRolemasterTask;
use App\Containers\AppSection\Rolemaster\UI\API\Requests\DeleteRolemasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteRolemasterAction extends ParentAction
{
    public function run(DeleteRolemasterRequest $request)
    {
        return app(DeleteRolemasterTask::class)->run($request->id);
    }
}
