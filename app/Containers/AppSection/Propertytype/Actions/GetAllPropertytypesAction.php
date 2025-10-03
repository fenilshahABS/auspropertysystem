<?php

namespace App\Containers\AppSection\Propertytype\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Propertytype\Tasks\GetAllPropertytypesTask;
use App\Containers\AppSection\Propertytype\UI\API\Requests\GetAllPropertytypesRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllPropertytypesAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllPropertytypesRequest $request)
    {
        return app(GetAllPropertytypesTask::class)->run();
    }
}
