<?php

namespace App\Containers\AppSection\Tenantusers\Tasks;

use App\Containers\AppSection\Tenantusers\Data\Repositories\TenantusersRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Mail;
use Config;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Tenantusers\Models\Emailtemplate;
use App\Containers\AppSection\Themesettings\Models\Themesettings;

class UpdateTenantusersPasswordTask extends Task
{
    protected TenantusersRepository $repository;

    public function __construct(TenantusersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, array $data, $getTenant)
    {
        try {

            $data_update = $this->repository->update($data, $id);
            $email_template = Emailtemplate::where('task', 'tenant_change_password')->first();
            $theme_setting = Themesettings::where('id', 1)->first();

            $tenantuserData = Tenantusers::where('id', $id)->first();
            $replaceText = array(
                '{user_name}'     => $tenantuserData->first_name . " " . $tenantuserData->last_name,
                '{year}'          => date("Y"),
                '{sitename}'          => $theme_setting->name,
            );
            $templateString       = strtr($email_template->message, $replaceText);
            $data['message']      = $templateString;
            $subject              = $tenantuserData->first_name . " " . $tenantuserData->last_name . " : " . $email_template->subject;
            $data['email']        = $tenantuserData->email;
            $data['name']         = $tenantuserData->first_name . " " . $tenantuserData->last_name;
            $data['sitename']     = $theme_setting->name;
            $data['tenantemail']     = $theme_setting->email;
            $data['system_link']     = $theme_setting->image_api_url;
            $data['tenantname']     = $theme_setting->name;
            $data['mobile']       = $theme_setting->mobile;
            $data['sitelogo'] =  ($theme_setting->logo) ? $theme_setting->image_api_url . $theme_setting->logo : "";

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

            Mail::send('appSection@tenantusers::tenantuser-changePassword', ['data' => $data], function ($m) use ($data, $subject) {
                $m->to($data['email'], $data['name'])->subject($subject);
                if (isset($data['attacheFile'])) $m->attach($data['attacheFile']);
            });

            $returnData['message'] = "Password Updated Successfully";
            return $returnData;
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
