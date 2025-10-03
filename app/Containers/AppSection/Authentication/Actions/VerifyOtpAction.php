<?php

namespace App\Containers\AppSection\Authentication\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Authentication\Tasks\VerifyOtpTask;
use App\Containers\AppSection\Tenantusers\UI\API\Requests\GetAllTenantusersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Carbon\Carbon;

class VerifyOtpAction extends ParentAction
{
    public function run(GetAllTenantusersRequest $request, $InputData)
    {

        return app(VerifyOtpTask::class)->run($InputData);
    }
}
