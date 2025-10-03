<?php

namespace App\Containers\AppSection\TaskManagement\Tasks;

use App\Containers\AppSection\TaskManagement\Data\Repositories\TaskManagementRepository;
use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Containers\AppSection\Tenantusers\Models\Emailtemplate;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Mail;
use Config;
use DateTime;
use Illuminate\Support\Carbon;

class SendTaskManagementRemainderMailTask extends ParentTask
{
    public function __construct(
        protected TaskManagementRepository $repository
    ) {
    }


    public function run($getData)
    {
        //try {

        $email_template = Emailtemplate::where('task', 'task_reminder')->first();
        $theme_setting = Themesettings::where('id', 1)->first();
        $username =  Tenantusers::find($getData['user_id'])->first_name;
        $tenantuserData = Tenantusers::where('id', $getData['user_id'])->first();

        $dateTimeString =  $getData['task_datetime'];
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $dateTimeString);
        $formattedDateTime = $dateTime->format('m-d-Y H:i:s');

        $replaceText = array(
            '{name}'    => $username,
            '{task_name}'    => $getData['task_name'],
            '{task_datetime}' => $formattedDateTime,
            '{sitename}'          => $theme_setting->name,
        );
        $templateString       = strtr($email_template->message, $replaceText);
        $datatenantuser['message']      = $templateString;
        $subject  = $email_template->subject;
        $datatenantuser['email']        = $tenantuserData->email;
        $datatenantuser['name']         = $tenantuserData->first_name . " " . $tenantuserData->last_name;
        $datatenantuser['sitename']     = $theme_setting->name;
        $datatenantuser['tenantemail']     = $theme_setting->email;
        $datatenantuser['system_link']     = $theme_setting->image_api_url;
        $datatenantuser['tenantname']     = $theme_setting->name;
        $datatenantuser['mobile']       = $theme_setting->mobile;
        $datatenantuser['sitelogo'] =  ($theme_setting->black_logo) ? $theme_setting->image_api_url . $theme_setting->black_logo : "";

        $config = array(
            'driver'     => trim($theme_setting->mailer),
            'host'       => trim($theme_setting->smtphost),
            'port'       => trim($theme_setting->port),
            'from'       => array('address' => $theme_setting->smtpemail, 'name' => $theme_setting->name),
            'encryption' => $theme_setting->ssl_tls_type,
            'username'   => trim($theme_setting->smtpemail),
            'password'   => trim($theme_setting->smtppassword),
            'sendmail'   => '/usr/sbin/sendmail -bs',
        );
        config::set('mail', $config);


        Mail::send('appSection@tenantusers::tenantuser-registered', ['data' => $datatenantuser], function ($m) use ($datatenantuser, $subject) {
            $m->to($datatenantuser['email'], $datatenantuser['name'])->subject($subject);
            if (isset($datatenantuser['attacheFile'])) $m->attach($datatenantuser['attacheFile']);
        });

        $custom_email = $getData['user_id'];
        $custom_email_array = explode(',',$custom_email);
        for($k=0;$k<count($custom_email_array);$k++){
            $datatenantuser['email']  = $custom_email_array[$k];
            $name = explode('@',$custom_email_array[$k]);
            $datatenantuser['name']   = $name[0];

            Mail::send('appSection@tenantusers::tenantuser-registered', ['data' => $datatenantuser], function ($m) use ($datatenantuser, $subject) {
                $m->to($datatenantuser['email'], $datatenantuser['name'])->subject($subject);
                if (isset($datatenantuser['attacheFile'])) $m->attach($datatenantuser['attacheFile']);
            });
        }


    }
}
