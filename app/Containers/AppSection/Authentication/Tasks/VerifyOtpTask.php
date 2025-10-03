<?php

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Containers\AppSection\Tenantusers\Models\LoginOtp;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Tenantusers\Models\Emailtemplate;
use App\Containers\AppSection\Tenantusers\Models\Eventtenantusers;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Tenantusers\Models\Themesettings;
use Exception;
use Config;
use Illuminate\Support\Facades\Mail;

class VerifyOtpTask extends ParentTask
{
    use HashIdTrait;
    public function run($InputData)
    {
        //-----------Generate Otp Function-----------------------
        $theme_setting = Themesettings::where('id', 1)->first();
        $mobile = $InputData->getMobile();
        //  $email = $InputData->getEmail();

        $mobileotp = $InputData->getMobileOtp();
        //   $emailotp = $InputData->getEmailOtp();

        $getData = LoginOtp::where('mobile', $mobile)
            ->where('mobileotp', $mobileotp)
            //    ->where('email', $email)
            //  ->where('emailotp', $emailotp)
            ->where('is_verify', 0)->orderBy('created_at', 'desc')->first();

        if ($getData !== null) {
            if ($getData) {
                $getData->is_verify = 1;
                $getData->verified_at = date('Y-m-d H:i:s');
                $getData->save();

                // $check_mobile_email_verification = Tenantusers::where('email', $email)->where('mobile', $mobile)->first();
                $check_mobile_email_verification = Tenantusers::where('mobile', $mobile)->first();
                if ($check_mobile_email_verification->mobile_verification == 'no') {
                    //   $check_mobile_email_verification->email_verification = 'yes';
                    $check_mobile_email_verification->mobile_verification = 'yes';
                    $check_mobile_email_verification->save();

                    //     $club_name = Eventtenantusers::select('club_name', 'logo', 'mobile')->where('id', $check_mobile_email_verification->tenant_id)->first();

                    //     //Send Welcome Email

                    //     $config = array(
                    //         'driver'     => trim($theme_setting->mailer),
                    //         'host'       => trim($theme_setting->smtphost),
                    //         'port'       => trim($theme_setting->port),
                    //         'from'       => array('address' => $theme_setting->smtpemail, 'name' => $theme_setting->name),
                    //         'encryption' => $theme_setting->ssl_tls_type,
                    //         'username'   => trim($theme_setting->smtpemail),
                    //         'password'   => trim($theme_setting->smtppassword),
                    //         'sendmail'   => '/usr/sbin/sendmail -bs',
                    //     );
                    //     config::set('mail', $config);

                    //     $email_to = $email;

                    //     // only mail send
                    //     $email_template = Emailtemplate::where('task', 'welcome')->first();

                    //     $replaceText_subject = array(
                    //         '{club_name}'          => $club_name->club_name,
                    //     );

                    //     $subject  = strtr($email_template->subject, $replaceText_subject);

                    //     $replaceText = array(
                    //         '{club_name}'    =>  $club_name->club_name,
                    //         '{user_name}' =>  $check_mobile_email_verification->first_name,
                    //     );
                    //     $templateString       = strtr($email_template->message, $replaceText);

                    //     $datatenantuser['message']      = $templateString;
                    //     $datatenantuser['sitename']     = $club_name->club_name;
                    //     $datatenantuser['sitelogo']     =  $theme_setting->image_api_url . $club_name->logo;
                    //     $datatenantuser['tenant_link']     = "http://yourclubworld.com/";
                    //     //  $datatenantuser['tenantname']     = $theme_setting->name;
                    //     $datatenantuser['mobile']       = $club_name->mobile;
                    //     $datatenantuser['email']        = $email_to;

                    //     Mail::send('appSection@tenantusers::welcome', ['data' => $datatenantuser], function ($m) use ($datatenantuser, $subject) {
                    //         $m->to($datatenantuser['email'])->subject($subject);
                    //         if (isset($datatenantuser['attacheFile'])) $m->attach($datatenantuser['attacheFile']);
                    //     });
                }
            }
            $modifiedData = $getData->toArray();
            $modifiedData['id'] = $this->encode($getData->id);
            $returnData = [
                'result' => true,
                'message' => 'Data Found',
                'object' => 'LoginOtp',
                'data' => $modifiedData,
            ];
        } else {
            $returnData = [
                'result' => false,
                'message' => 'Error: Data not found.',
                'object' => 'LoginOtp',
                'data' => [],
            ];
        }
        return $returnData;
    }
}
