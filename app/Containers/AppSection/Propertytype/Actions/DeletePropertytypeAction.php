<?php

namespace App\Containers\AppSection\Propertytype\Actions;

use App\Containers\AppSection\Propertytype\Tasks\DeletePropertytypeTask;
use App\Containers\AppSection\Propertytype\UI\API\Requests\DeletePropertytypeRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeletePropertytypeAction extends ParentAction
{
    /**
     * @param DeletePropertytypeRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeletePropertytypeRequest $request)
    {
        return app(DeletePropertytypeTask::class)->run($request->id);
    }
}
