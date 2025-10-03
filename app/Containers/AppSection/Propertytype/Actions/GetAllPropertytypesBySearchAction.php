<?php

namespace App\Containers\AppSection\Propertytype\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Propertytype\Tasks\GetAllPropertytypesBySearchTask;
use App\Containers\AppSection\Propertytype\UI\API\Requests\GetAllPropertytypesRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllPropertytypesBySearchAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllPropertytypesRequest $request, $InputData)
    {
        return app(GetAllPropertytypesBySearchTask::class)->run($InputData);
    }
}
