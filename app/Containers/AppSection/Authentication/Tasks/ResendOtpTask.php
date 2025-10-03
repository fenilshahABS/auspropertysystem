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

class ResendOtpTask extends ParentTask
{
    use HashIdTrait;
    public function run(array $data)
    {
        //--------------------Api Call For OTP Send to User---------------------------------

        $theme_setting = Themesettings::where('id', 1)->first();
        $otp_api_key = $theme_setting->sms_api_key;
        $mobile = $data['mobile'];
        $mobileotp = $data['mobileotp'];


        // if ($data['email'] == "shahfenil0305@gmail.com" || $data['email'] == "rushabh.devrup@absoluteweb.in") {
        //     $data['mobileotp'] = 123456;
        //     $mobileotp = $data['mobileotp'];
        //     $data['emailotp'] = 123456;
        //     // Mobile Otp Sent 
        //     $apiUrl =  'https://2factor.in/API/R1/?module=TRANS_SMS&apikey=' . $otp_api_key . '&to=' . $mobile . '&from=absweb&templatename=User+Verification&var1=User&var2=' . $mobileotp;   // SMS
        //     //    $apiUrl = 'https://2factor.in/API/V1/' . $otp_api_key . '/SMS/+91' . $mobile . '/' . $otp . '/OTP1';    // Call
        //     $response = file_get_contents($apiUrl);
        // } else {
        // Mobile Otp Sent 
        $apiUrl =  'https://2factor.in/API/R1/?module=TRANS_SMS&apikey=' . $otp_api_key . '&to=' . $mobile . '&from=absweb&templatename=User+Verification&var1=User&var2=' . $mobileotp;   // SMS
        //    $apiUrl = 'https://2factor.in/API/V1/' . $otp_api_key . '/SMS/+91' . $mobile . '/' . $otp . '/OTP1';    // Call
        $response = file_get_contents($apiUrl);
        //   }


        // Mail Otp Sent

        // $getUser = Tenantusers::where('email', $data['email'])->where('mobile', $data['mobile'])->first();
        // $club_name = Eventtenantusers::select('club_name', 'logo', 'mobile')->where('id', $getUser->tenant_id)->first();

        // $config = array(
        //     'driver'     => trim($theme_setting->mailer),
        //     'host'       => trim($theme_setting->smtphost),
        //     'port'       => trim($theme_setting->port),
        //     'from'       => array('address' => $theme_setting->smtpemail, 'name' => $theme_setting->name),
        //     'encryption' => $theme_setting->ssl_tls_type,
        //     'username'   => trim($theme_setting->smtpemail),
        //     'password'   => trim($theme_setting->smtppassword),
        //     'sendmail'   => '/usr/sbin/sendmail -bs',
        // );
        // config::set('mail', $config);

        // $email_to = $data['email'];

        // // only mail send
        // $email_template = Emailtemplate::where('task', 'email_otp')->first();

        // $replaceText_subject = array(
        //     '{app_name}'          => $club_name->club_name,
        // );

        // $subject  = strtr($email_template->subject, $replaceText_subject);

        // $replaceText = array(
        //     '{app_name}'    =>  $club_name->club_name,
        //     '{user_name}' =>  $getUser->first_name,
        //     '{otp}'    =>  $data['emailotp']
        // );
        // $templateString       = strtr($email_template->message, $replaceText);

        // $datatenantuser['message']      = $templateString;
        // $datatenantuser['sitename']     = $club_name->club_name;
        // $datatenantuser['sitelogo']     =  $theme_setting->image_api_url . $club_name->logo;
        // $datatenantuser['tenant_link']     =  "http://yourclubworld.com/";
        // //$datatenantuser['tenantname']     = $theme_setting->name;
        // $datatenantuser['mobile']       = $club_name->mobile;
        // $datatenantuser['email']        = $email_to;

        // Mail::send('appSection@tenantusers::email-otp', ['data' => $datatenantuser], function ($m) use ($datatenantuser, $subject) {
        //     $m->to($datatenantuser['email'])->subject($subject);
        //     if (isset($datatenantuser['attacheFile'])) $m->attach($datatenantuser['attacheFile']);
        // });

        $saveData = LoginOtp::create($data);
        $getData = LoginOtp::where('id', $saveData->id)->first();
        $returnData = array();
        if ($getData !== null) {
            $returnData = [
                'result' => true,
                'message' => 'OTP Sent Successfully',
                'object' => 'LoginOtp',
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
