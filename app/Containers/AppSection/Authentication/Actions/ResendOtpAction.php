<?php

namespace App\Containers\AppSection\Authentication\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Authentication\Tasks\ResendOtpTask;
use App\Containers\AppSection\Tenantusers\UI\API\Requests\CreateTenantusersRequest;

use App\Ship\Parents\Actions\Action as ParentAction;

class ResendOtpAction extends ParentAction
{
    public function run(CreateTenantusersRequest $request, $InputData)
    {

        //-----------Generate Otp Function-----------------------

        function generateMobileOTP()
        {
            return rand(100000, 999999);
        }

        // function generateEmailOTP()
        // {
        //     return rand(100000, 999999);
        // }

        $mobileotp = generateMobileOTP();
        //   $emailotp = generateEmailOTP();
        $mobile = $InputData->getMobile();
        //  $email = $InputData->getEmail();

        $data = $request->sanitizeInput([
            'mobile' => $mobile,
            'mobileotp' => $mobileotp,
            //  'email' => $email,
            //   'emailotp' => $emailotp,
            'is_verify' => 0
        ]);

        return app(ResendOtpTask::class)->run($data);
    }
}
