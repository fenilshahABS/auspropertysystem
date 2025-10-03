<?php

namespace App\Containers\AppSection\Tenantusers\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Tenantusers\Data\Repositories\TenantusersRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Mail;
use Config;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Tenant\Models\Tenant;
use App\Containers\AppSection\Tenantusers\Models\Emailtemplate;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Absoluteweb\AbsolutewebRepository;

class CreateTenantusersTask extends Task
{
    use HashIdTrait;
    protected TenantusersRepository $repository;

    public function __construct(TenantusersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($data)
    {
        // try {
        $data['mobile'] = (string) $data['mobile'];
        $create = Tenantusers::create($data);
        $getData = Tenantusers::where('id', $create->id)->first();
        $image_api_url = Themesettings::where('id', 1)->first();
        if (!empty($getData)) {
            if ($getData->role_id != 1) {
                $sendWelcomeNotification = AbsolutewebRepository::sendWelcomeNotification($getData);
            }

            if ($getData->role_id != 4) {
                // Mail Sent to User
                $email_template = Emailtemplate::where('task', 'welcome_user')->first();
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
                // $subject              = $tenantuserData->first_name . " " . $tenantuserData->last_name . " : " . $email_template->subject;
                $replaceText_subject = array(
                    '{user_name}'          => $tenantuserData->first_name . " " . $tenantuserData->last_name,
                );
                $subject  = strtr($email_template->subject, $replaceText_subject);
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
            // }

            $returnData['message'] = "Data Created";
            $returnData['data']['object'] = "pro_tenantusers";
            $returnData['data']['id'] = $this->encode($getData['id']);
            $returnData['data']['role_id'] = $this->encode($getData['role_id']);
            $returnData['data']['first_name'] = $getData['first_name'];
            $returnData['data']['last_name'] = $getData['last_name'];
            $returnData['data']['profile_image'] = ($getData['profile_image']) ? $image_api_url->image_api_url . $getData['profile_image'] : "";
            $returnData['data']['id_proof'] = ($getData['id_proof']) ? $image_api_url->image_api_url . $getData['id_proof'] : "";
            $returnData['data']['dob'] = $getData['dob'];
            $returnData['data']['gender'] = $getData['gender'];
            $returnData['data']['email'] = $getData['email'];
            $returnData['data']['mobile'] = $getData['mobile'];
            $returnData['data']['address'] = $getData['address'];
            $returnData['data']['country'] = $getData['country'];
            $returnData['data']['state'] = $getData['state'];
            $returnData['data']['city'] = $getData['city'];
            $returnData['data']['zipcode'] = $getData['zipcode'];
            $returnData['data']['is_active'] = $getData['is_active'];
            $returnData['data']['is_verify'] = $getData['is_verify'];
        } else {
            $returnData['message'] = "Data Not Found";
            $returnData['object'] = "pro_tenantusers";
        }
        return $returnData;
        // } catch (Exception $exception) {
        //     throw new CreateResourceFailedException();
        // }
    }
}
