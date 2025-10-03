<?php

namespace App\Containers\AppSection\Propertymaster\Actions;

use App\Containers\AppSection\Propertymaster\Tasks\DeletePropertyShareDetailsTask;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\DeletePropertymasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeletePropertyShareDetailsAction extends ParentAction
{

    public function run(DeletePropertymasterRequest $request)
    {
        return app(DeletePropertyShareDetailsTask::class)->run($request->id);
    }
}
