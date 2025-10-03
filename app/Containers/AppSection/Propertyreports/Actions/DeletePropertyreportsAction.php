<?php

namespace App\Containers\AppSection\Propertyreports\Actions;

use App\Containers\AppSection\Propertyreports\Tasks\DeletePropertyreportsTask;
use App\Containers\AppSection\Propertyreports\UI\API\Requests\DeletePropertyreportsRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeletePropertyreportsAction extends ParentAction
{
    /**
     * @param DeletePropertyreportsRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeletePropertyreportsRequest $request): int
    {
        return app(DeletePropertyreportsTask::class)->run($request->id);
    }
}
