<?php

namespace App\Containers\AppSection\Propertymaster\Actions;

use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Tasks\FindPropertymasterByIdTask;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\FindPropertymasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindPropertymasterByIdAction extends ParentAction
{
    /**
     * @throws NotFoundException
     */
    public function run(FindPropertymasterByIdRequest $request)
    {
        return app(FindPropertymasterByIdTask::class)->run($request->id);
    }
}
