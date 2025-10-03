<?php

namespace App\Containers\AppSection\Propertymaster\Actions;

use App\Containers\AppSection\Propertymaster\Tasks\DeletePropertymasterTask;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\DeletePropertymasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeletePropertymasterAction extends ParentAction
{

    public function run(DeletePropertymasterRequest $request)
    {
        return app(DeletePropertymasterTask::class)->run($request->id);
    }
}
