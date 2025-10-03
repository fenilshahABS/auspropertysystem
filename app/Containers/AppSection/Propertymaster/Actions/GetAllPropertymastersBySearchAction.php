<?php

namespace App\Containers\AppSection\Propertymaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Propertymaster\Tasks\GetAllPropertymastersBySearchTask;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\GetAllPropertymastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllPropertymastersBySearchAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllPropertymastersRequest $request, $InputData)
    {
        return app(GetAllPropertymastersBySearchTask::class)->run($InputData);
    }
}
