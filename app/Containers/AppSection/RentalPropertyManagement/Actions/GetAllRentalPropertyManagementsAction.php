<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\RentalPropertyManagement\Tasks\GetAllRentalPropertyManagementsTask;
use App\Containers\AppSection\RentalPropertyManagement\UI\API\Requests\GetAllRentalPropertyManagementsRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalPropertyManagementsAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllRentalPropertyManagementsRequest $request)
    {
        return app(GetAllRentalPropertyManagementsTask::class)->run($request);
    }
}
