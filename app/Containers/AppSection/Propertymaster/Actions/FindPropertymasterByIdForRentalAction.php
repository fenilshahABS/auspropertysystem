<?php

namespace App\Containers\AppSection\Propertymaster\Actions;

use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Tasks\FindPropertymasterByIdForRentalTask;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\UpdatePropertymasterRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindPropertymasterByIdForRentalAction extends ParentAction
{

    public function run(UpdatePropertymasterRequest $request, $InputData)
    {
        return app(FindPropertymasterByIdForRentalTask::class)->run($request->id, $InputData);
    }
}
