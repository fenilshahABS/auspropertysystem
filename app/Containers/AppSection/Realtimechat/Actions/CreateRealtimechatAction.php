<?php

namespace App\Containers\AppSection\Realtimechat\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Realtimechat\Models\Realtimechat;
use App\Containers\AppSection\Realtimechat\Tasks\CreateRealtimechatTask;
use App\Containers\AppSection\Realtimechat\UI\API\Requests\CreateRealtimechatRequest;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CreateRealtimechatAction extends ParentAction
{
    use HashIdTrait;
    public function run(CreateRealtimechatRequest $request, $InputData)
    {
        $tenant = Auth::user();

        $to_user_id = $this->decode($InputData->getToUserId());
        $chatimages = $InputData->getImage();
        // if ($InputData->getImage() != null) {
        //     $manager = new ImageManager(Driver::class);
        //     $image = $manager->read($InputData->getImage());
        //     if (!file_exists(public_path('chatimages/'))) {
        //         mkdir(public_path('chatimages/'), 0755, true);
        //     }
        //     $image_type = "png";
        //     $folderPath = 'public/chatimages/';
        //     $file =  uniqid() . '.' . $image_type;
        //     $saveimage = $image->toPng()->save(public_path('chatimages/' . $file));
        //     $chatImage  =  $folderPath . $file;
        // } else {
        //     $chatImage = '';
        // }
        if ($InputData->getImage() != null) {
            if (!file_exists(public_path('chatimages/'))) {
                mkdir(public_path('chatimages/'), 0755, true);
            }

            // list($type, $data_type) = explode(';', $chatimages->getImage());
            // list(, $data_type) = explode(',', $data_type);
            // $folderPath = 'public/chatimages/';
            // $image_bace64 = base64_decode($InputData->getImage());
            // if ($type == "data:application/pdf") {
            //     $image_type = "pdf";
            //     $file = uniqid() . '.' . $image_type;
            //     $path = public_path('chatimages/' . $file);
            //     file_put_contents($path, $image_bace64);


            list($type, $data_type) = explode(';', $chatimages);
            list(, $data_type) = explode(',', $data_type);
            $folderPath = 'public/chatimages/';
            $image_bace64 = base64_decode($data_type);
            if ($type == "data:application/pdf") {
                $image_type = "pdf";
                $file = uniqid() . '.' . $image_type;
                $path = public_path('chatimages/' . $file);
                file_put_contents($path, $image_bace64);
            } else {
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($InputData->getImage());
                $image_type = "png";
                $file =  uniqid() . '.' . $image_type;
                $saveimage = $image->toPng()->save(public_path('chatimages/' . $file));
                //   $chatImage  =  $folderPath . $file;
            }
            $chatImage =  $folderPath . $file;
        } else {
            $chatImage = '';
        }






        $data = $request->sanitizeInput([
            "type" => $InputData->getType(),
            "message" => $InputData->getMessage(),
            "chatting_date_time" => date('Y-m-d H:i:s'),
            "status" => 0,
            "sent_user_id" => $tenant['id'],
            "sent_user_name" => Tenantusers::find($tenant['id'])->first_name,
        ]);
        $data['image'] = $chatImage;
        $data['to_user_id'] = $to_user_id;
        $data['sender_type'] = $this->decode($InputData->getSenderType());
        return app(CreateRealtimechatTask::class)->run($data);
    }
}
