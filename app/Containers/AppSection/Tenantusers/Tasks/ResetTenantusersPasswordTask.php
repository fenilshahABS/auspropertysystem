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
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;

class ResetTenantusersPasswordTask extends Task
{
    use HashIdTrait;
    protected TenantusersRepository $repository;

    public function __construct(TenantusersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($InputData)
    {
        //  try {

        $returnData = array();
        $getData = TenantUsers::where('email', $InputData->getEmail())->first();

        if ($getData !== null) {
            $rand_character = $this->encode(rand(1, 10000));
            $uniquePassword = substr($rand_character, 0, 8);
            $getData->password = Hash::make($uniquePassword);
            $getData->user_has_key = $uniquePassword;
            $getData->save();
            if ($getData->user_has_key == $uniquePassword) {
                // Mail Sent to User
                $email_template = Emailtemplate::where('task', 'tenant_reset_password')->first();
                $theme_setting = Themesettings::where('id', 1)->first();

                $tenantuserData = Tenantusers::where('id', $getData->id)->first();
                $profile_img =  $tenantuserData->profile_image;
                $replaceText = array(
                    '{user_name}'    => $tenantuserData->first_name . " " . $tenantuserData->middle_name . " " . $tenantuserData->last_name,
                    '{email}'    => $tenantuserData->email,
                    '{password}'     => $tenantuserData->user_has_key,
                    '{sitename}'          => $theme_setting->name,
                );
                $templateString       = strtr($email_template->message, $replaceText);
                $datatenantuser['message']      = $templateString;
                $subject              = $tenantuserData->first_name . " " . $tenantuserData->last_name . " : " . $email_template->subject;
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
            }

            $returnData['message'] = "Password reset successfully!!";
            $returnData['object'] = "tenantusers";
        } else {
            $returnData['message'] = "User Not found.";
            $returnData['object'] = "tenantusers";
            $returnData['data'] = [];
        }


        return $returnData;
        // } catch (Exception $e) {
        //     return [
        //         'message' => 'Error: Failed to update password. Please try again later.',
        //         'object' => 'tenantusers',
        //         'data' => [],
        //     ];
        // }
    }
}
