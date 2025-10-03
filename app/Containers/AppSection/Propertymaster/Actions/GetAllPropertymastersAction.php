<?php

namespace App\Containers\AppSection\Propertymaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Propertymaster\Tasks\GetAllPropertymastersRentalTask;
use App\Containers\AppSection\Propertymaster\Tasks\GetAllPropertymastersTask;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\GetAllPropertymastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllPropertymastersAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllPropertymastersRequest $request)
    {
        if ($request->flag == "rental_list") {
            return app(GetAllPropertymastersRentalTask::class)->run($request);
        } else {
            return app(GetAllPropertymastersTask::class)->run();
        }
    }
}
