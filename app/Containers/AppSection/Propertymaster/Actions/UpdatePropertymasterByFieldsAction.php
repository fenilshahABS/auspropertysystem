<?php

namespace App\Containers\AppSection\Propertymaster\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Tasks\UpdatePropertymasterByFieldsTask;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\UpdatePropertymasterRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdatePropertymasterByFieldsAction extends ParentAction
{
    use HashIdTrait;
    public function run(UpdatePropertymasterRequest $request, $InputData)
    {

        return app(UpdatePropertymasterByFieldsTask::class)->run($InputData, $request->id);
    }
}
