<?php

namespace App\Containers\AppSection\Authentication\UI\API\Controllers;

use App\Containers\AppSection\Authentication\Actions\ResendOtpAction;
use App\Containers\AppSection\Authentication\Actions\VerifyOtpAction;
use App\Containers\AppSection\Tenantusers\UI\API\Requests\CreateTenantusersRequest;
use App\Containers\AppSection\Tenantusers\UI\API\Requests\GetAllTenantusersRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use App\Containers\AppSection\Tenantusers\Entities\Tenantusers;

class ResendOtpController extends ApiController
{

    public function ResendOtp(CreateTenantusersRequest $request)
    {
        $InputData = new Tenantusers($request);
        $tenantusers = app(ResendOtpAction::class)->run($request, $InputData);
        return $tenantusers;
    }
    public function VerifyOtp(GetAllTenantusersRequest $request)
    {

        $InputData = new Tenantusers($request);
        $tenantusers = app(VerifyOtpAction::class)->run($request, $InputData);
        return $tenantusers;
    }
}
