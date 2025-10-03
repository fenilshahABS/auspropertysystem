<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Containers\AppSection\RentalInvoiceManual\Data\Repositories\RentalInvoiceManualRepository;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManualDetails;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Mail;
use Config;
use App\Containers\AppSection\Tenantusers\Models\Emailtemplate;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Themesettings\Models\Themesettings;

class SendInvoicePdfonMailTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RentalInvoiceManualRepository $repository
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run($path, $InputData)
    {
        try {


            $property_id = $this->decode($InputData->getPropertyId());

            $email_template = Emailtemplate::where('task', 'send_invoice_pdf')->first();
            $theme_setting = Themesettings::where('id', 1)->first();
            //echo $property_id;die;
            $getPropertyOwners = PropertymasterShareDetails::select('property_owner_id')->where('pro_property_master_id', $property_id)->get();

            if (!empty($getPropertyOwners)) {
                for ($i = 0; $i < count($getPropertyOwners); $i++) {
                    $tenantuserData = Tenantusers::where('id', $getPropertyOwners[$i]->property_owner_id)->first();

                    $replaceText = array(
                        '{user_name}'    => $tenantuserData->first_name . " " . $tenantuserData->middle_name . " " . $tenantuserData->last_name,
                        '{property_name}'    => Propertymaster::find($property_id)->property_name,
                        '{sitename}'          => $theme_setting->name,
                    );
                    $templateString       = strtr($email_template->message, $replaceText);
                    $datatenantuser['message']      = $templateString;
                    $subject              = $email_template->subject;
                    $datatenantuser['email']        = $tenantuserData->email;
                    $datatenantuser['name']         = $tenantuserData->first_name . " " . $tenantuserData->last_name;
                    $datatenantuser['sitename']     = $theme_setting->name;
                    $datatenantuser['tenantemail']     = $theme_setting->email;
                    $datatenantuser['system_link']     = $theme_setting->image_api_url;
                    $datatenantuser['tenantname']     = $theme_setting->name;
                    $datatenantuser['mobile']       = $theme_setting->mobile;
                    $datatenantuser['sitelogo'] =  ($theme_setting->black_logo) ? $theme_setting->image_api_url . $theme_setting->black_logo : "";
                    $datatenantuser['attacheFile'] = $path;
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


                    $check =  Mail::send('appSection@tenantusers::tenantuser-registered', ['data' => $datatenantuser], function ($m) use ($datatenantuser, $subject) {
                        $m->to($datatenantuser['email'], $datatenantuser['name'])->subject($subject);
                        if (isset($datatenantuser['attacheFile'])) $m->attach($datatenantuser['attacheFile']);
                    });
                }
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            if ($check) {
                $returnData['message'] = "Mail Send Successfully";
            } else {
                $returnData['message'] = "Failed to Send Mail";
            }

            return $returnData;
        } catch (Exception) {
            throw new CreateResourceFailedException();
        }
    }
}
