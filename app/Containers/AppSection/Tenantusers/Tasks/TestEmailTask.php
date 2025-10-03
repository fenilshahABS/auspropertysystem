<?php

namespace App\Containers\AppSection\Tenantusers\Tasks;

use App\Containers\AppSection\Tenantusers\Data\Repositories\TenantusersRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Mail;
use Config;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Tenantusers\Models\Emailtemplate;
use App\Containers\AppSection\Masterthemesettings\Models\Masterthemesettings;
use App\Containers\AppSection\Themesettings\Models\Themesettings;

class TestEmailTask extends Task
{
    protected TenantusersRepository $repository;

    public function __construct(TenantusersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($getTenant)
    {
        //try {

        // Mail Sent to User & Admin
        $email_template = Emailtemplate::where('task', 'test_email')->first();
        $theme_setting = Themesettings::where('id', 1)->first();

        $replaceText = array(
            //'{user_name}'     => $tenantuserInputData->getName(),
            //'{tenant_name}'   => $parent_tenantuser->name,
            //'{site_url}'      => "https://ihealth.care/",
            //'{user_id}'       => $tenantuserInputData->getEmail(),
            //'{password}'      => $uniquePassword,
            '{year}'          => date("Y"),
        );
        $templateString       = strtr($email_template->message, $replaceText);
        $data['message']      = $templateString;
        $subject              = $email_template->subject;
        $data['email']        = 'fenil.s1991@gmail.com';
        $data['name']         = 'Fenil Shah';
        $data['sitename']     = $theme_setting->name;
        $data['tenantemail']     = $theme_setting->email;
        $data['tenantname']     = $theme_setting->name;
        $data['mobile']       = $theme_setting->mobile;
        $data['sitelogo'] =  "https://jainpathshala.in/public/front/assets/img/logo.png";

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

        Mail::send('appSection@tenantusers::testemail', ['data' => $data], function ($m) use ($data, $subject) {
            $m->to($data['email'], $data['name'])->subject($subject);
            if (isset($data['attacheFile'])) $m->attach($data['attacheFile']);
        });
        $returnData['message'] = "Success";
        return $returnData;
        //}
        //catch (Exception $exception) {
        //    throw new CreateResourceFailedException();
        //}
    }
}
