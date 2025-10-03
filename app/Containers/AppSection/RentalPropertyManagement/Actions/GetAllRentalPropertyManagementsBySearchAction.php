<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\RentalPropertyManagement\Tasks\GetAllRentalPropertyManagementsBySearchTask;
use App\Containers\AppSection\RentalPropertyManagement\UI\API\Requests\GetAllRentalPropertyManagementsRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRentalPropertyManagementsBySearchAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllRentalPropertyManagementsRequest $request, $InputData)
    {
        return app(GetAllRentalPropertyManagementsBySearchTask::class)->run($InputData);
    }
}
