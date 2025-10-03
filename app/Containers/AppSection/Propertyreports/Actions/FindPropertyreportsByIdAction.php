<?php

namespace App\Containers\AppSection\Propertyreports\Actions;

use App\Containers\AppSection\Propertyreports\Models\Propertyreports;
use App\Containers\AppSection\Propertyreports\Tasks\FindPropertyreportsByIdTask;
use App\Containers\AppSection\Propertyreports\UI\API\Requests\FindPropertyreportsByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindPropertyreportsByIdAction extends ParentAction
{
    /**
     * @throws NotFoundException
     */
    public function run(FindPropertyreportsByIdRequest $request): Propertyreports
    {
        return app(FindPropertyreportsByIdTask::class)->run($request->id);
    }
}
