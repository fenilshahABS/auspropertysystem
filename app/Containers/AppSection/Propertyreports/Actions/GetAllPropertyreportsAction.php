<?php

namespace App\Containers\AppSection\Propertyreports\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Propertyreports\Tasks\GetAllPropertyreportsTask;
use App\Containers\AppSection\Propertyreports\UI\API\Requests\GetAllPropertyreportsRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllPropertyreportsAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllPropertyreportsRequest $request, $InputData)
    {
        return app(GetAllPropertyreportsTask::class)->run($InputData);
    }
}
