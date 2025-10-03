<?php

namespace App\Containers\AppSection\Propertytype\Actions;

use App\Containers\AppSection\Propertytype\Models\Propertytype;
use App\Containers\AppSection\Propertytype\Tasks\FindPropertytypeByIdTask;
use App\Containers\AppSection\Propertytype\UI\API\Requests\FindPropertytypeByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindPropertytypeByIdAction extends ParentAction
{
    /**
     * @throws NotFoundException
     */
    public function run(FindPropertytypeByIdRequest $request)
    {
        return app(FindPropertytypeByIdTask::class)->run($request->id);
    }
}
