<?php

namespace App\Containers\AppSection\Rolemaster\Actions;

use App\Containers\AppSection\Rolemaster\Models\Rolemaster;
use App\Containers\AppSection\Rolemaster\Tasks\FindRolemasterByIdTask;
use App\Containers\AppSection\Rolemaster\UI\API\Requests\FindRolemasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindRolemasterByIdAction extends ParentAction
{
    public function run(FindRolemasterByIdRequest $request)
    {
        return app(FindRolemasterByIdTask::class)->run($request->id);
    }
}
