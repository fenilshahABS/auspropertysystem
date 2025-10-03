<?php

namespace App\Containers\AppSection\Authentication\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Authentication\Classes\LoginCustomAttribute;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tasks\MakeRefreshCookieTask;
use App\Containers\AppSection\Authentication\UI\API\Requests\LoginProxyPasswordGrantRequest;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Rolemaster\Models\Rolemaster;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Authentication\Tasks\ResendOtpTask;
use App\Containers\AppSection\Splashscreen\Models\Splashscreen;

class ProxyLoginForTenantWebClientAction extends ParentAction
{
    use HashIdTrait;
    public function __construct(
        private readonly CallOAuthServerTask $callOAuthServerTask,
        private readonly MakeRefreshCookieTask $makeRefreshCookieTask,
        private readonly ResendOtpTask $resendOtpTask,
    ) {
    }

    /**
     * @throws LoginFailedException
     * @throws IncorrectIdException
     * @throws NotFoundException
     */
    public function run(LoginProxyPasswordGrantRequest $request): array
    {

        $sanitizedData = $request->sanitizeInput(
            [
                ...array_keys(config('appSection-authentication.login.attributes')),
                'password',
            ]
        );


        $userData = Tenantusers::where('email', $sanitizedData['email'])->where('is_active', 'Active')->first();
        //     $userData = Tenantusers::where('mobile', $sanitizedData['mobile'])->where('is_active', 'Active')->first();

        if (isset($userData->role_id)) {

            if ($userData->is_verify == 1) {

                // $get_club_code = Splashscreen::where('tenant_id', $userData->tenant_id)->first();
                // $club_code = $get_club_code->club_code;
                //     if ($club_code == $sanitizedData['club_code']) {
                //       $password = $userData->user_has_key;

                $sanitizedData['email'] = $userData->email;
                //    $sanitizedData['password'] = $password;
                // function generateMobileOTP()
                // {
                //     return rand(100000, 999999);
                // }

                // function generateEmailOTP()
                // {
                //     return rand(100000, 999999);
                // }

                //   $mobileotp = generateMobileOTP();
                //   $emailotp = generateEmailOTP();

                // $data = $request->sanitizeInput([
                //     'mobile' => $sanitizedData['mobile'],
                //     'mobileotp' => $mobileotp,
                //     //    'email' => $sanitizedData['email'],
                //     //   'emailotp' => $emailotp,
                //     'is_verify' => 0
                // ]);
                // $SendOtp = $this->resendOtpTask->run($data);

                config(['auth.guards.api.provider' => 'tenant']);

                //$password = Hash::make($sanitizedData['password']);
                //echo $password;die;

                [$loginFieldValue] = LoginCustomAttribute::extract($sanitizedData);
                $sanitizedData = $this->enrichSanitizedData($loginFieldValue, $sanitizedData);


                $responseContent = $this->callOAuthServerTask->run($sanitizedData, $request->headers->get('accept-language'));

                $refreshCookie = $this->makeRefreshCookieTask->run($responseContent['refresh_token']);

                $user_id = $this->encode((int)$userData->id);
                $responseContent['user_id'] = $user_id;
                $role_id = $this->encode((int)$userData->role_id);
                $responseContent['role_id'] = $role_id;


                return [
                    'response_content' => $responseContent,
                    'refresh_cookie' => $refreshCookie,
                ];
                // } else {
                //     // $returnData['result'] = false;
                //     $returnData['message'] = "Club Code Is Different For The User";
                //     http_response_code(500);
                //     echo json_encode($returnData);
                //     exit();
                // }
            } else {
                // $returnData['result'] = false;
                if ($userData->is_verify == 2) {
                    $returnData['message'] = "You have profile has been rejected!, Please Contact To Administrator..";
                } else {
                    $returnData['message'] = "You have profile is under verification!.";
                }

                http_response_code(500);
                echo json_encode($returnData);
                exit();
            }
        } else {
            //$returnData['result'] = false;
            $returnData['message'] = "User Not Found";
            http_response_code(500);
            echo json_encode($returnData);
            exit();
        }
    }

    private function enrichSanitizedData(string $username, array $sanitizedData): array
    {
        $sanitizedData['username'] = $username;
        $sanitizedData['client_id'] = config('appSection-authentication.clients.mobile.id');
        $sanitizedData['client_secret'] = config('appSection-authentication.clients.mobile.secret');
        $sanitizedData['grant_type'] = 'password';
        $sanitizedData['scope'] = '';

        return $sanitizedData;
    }
}
