<?php

namespace App\Containers\AppSection\Themesettings\Tasks;

use App\Containers\AppSection\Themesettings\Data\Repositories\ThemesettingsRepository;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Apiato\Core\Traits\HashIdTrait;

class UpdateThemesettingsTask extends ParentTask
{
    use HashIdTrait;
    protected ThemesettingsRepository $repository;
    public function __construct(ThemesettingsRepository $repository)
    {
        $this->repository = $repository;
    }


    public function run(array $save_data_image, $id, $InputData)
    {
        //    try {

        $getData = Themesettings::where('id', $id)->first();

        if ($getData != "" && $getData != null) {
            $getData->name = $InputData->getName();
            if ($save_data_image['white_logo'] != "") {
                $getData->white_logo = $save_data_image['white_logo'];
            }
            if ($save_data_image['black_logo'] != "") {
                $getData->black_logo = $save_data_image['black_logo'];
            }
            if ($save_data_image['fevicon'] != "") {
                $getData->favicon = $save_data_image['fevicon'];
            }
            $getData->description = $InputData->getDescription();
            $getData->mobile = $InputData->getMobile();
            $getData->email = $InputData->getEmail();
            $getData->address = $InputData->getAddress();
            $getData->mailer = $InputData->getMailer();
            $getData->mailpath = $InputData->getMailpath();
            $getData->smtphost = $InputData->getSmtphost();
            $getData->smtpemail = $InputData->getSmtpemail();
            $getData->smtppassword = $InputData->getSmtppassword();
            $getData->port = $InputData->getPort();
            $getData->ssl_tls_type = $InputData->getSsltlstype();
            $getData->google_play_store_link = $InputData->getGoogleplaystorelink();
            $getData->ios_play_store_link = $InputData->getIosplaystorelink();
            $getData->recaptcha_key = $InputData->getRecaptchakey();
            $getData->recaptcha_secret = $InputData->getRecaptchasecret();
            $getData->facebook_link = $InputData->getFaceBookLink();
            $getData->instagram_link = $InputData->getInstagramLink();
            $getData->youtube_link = $InputData->getYoutubeLink();
            $getData->image_api_url = $InputData->getImageApiUrl();
            $getData->sms_api_key = $InputData->getSmsApiKey();
            $getData->partner_client_commision = $InputData->getPartnerClientCommission();
            $getData->partner_client_min_percentage = $InputData->getPartnerClientMinPercentage();
            $getData->currency = $InputData->getCurrency();
            $getData->tax = $InputData->getTax();
            $getData->rent_late_fees = $InputData->getRentLateFees();
            $getData->save();

            $returnData['message'] = "Data Updated";
            $returnData['data'] =  $this->repository->find($id);
            return $returnData;
        } else {
            $returnData = [
                'message' => "No Data Found",
                'object' => "pro_master_theme_settings",
                'data' => [],
            ];
        }
        return $returnData;
        // } catch (Exception $e) {
        //     return [
        //         'message' => 'Error: Failed to update resource. Please try again later.',
        //         'object' => 'pro_master_theme_settings',
        //         'data' => [],
        //     ];
        // }
    }
}
