<?php

namespace App\Containers\AppSection\Themesettings\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Containers\AppSection\Themesettings\Tasks\UpdateThemesettingsTask;
use App\Containers\AppSection\Themesettings\UI\API\Requests\UpdateThemesettingsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Intervention\Image\Facades\Image;
use Apiato\Core\Traits\HashIdTrait;
use Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UpdateThemesettingsAction extends ParentAction
{
    use HashIdTrait;
    public function run(UpdateThemesettingsRequest $request, $InputData)
    {

        //------------- Logo And Fevicon Upload logic -----------------------------------

        $imagearray = array();
        $imagearray['white_logo'] = $InputData->getWhiteLogoencode();
        $imagearray['black_logo'] = $InputData->getBlackLogoencode();
        $imagearray['fevicon'] = $InputData->getFaviconencode();
        $image_upload = [];
        $save_data_image = [];

        foreach ($imagearray as $imagearray_key => $imagearray_value) {
            if (isset($imagearray[$imagearray_key]) && $imagearray[$imagearray_key] != null) {
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($imagearray_value);
                if (!file_exists(public_path($imagearray_key . '/'))) {
                    mkdir(public_path($imagearray_key . '/'), 0755, true);
                }
                $image_type = "png";
                $folderPath = 'public/' . $imagearray_key . '/';
                $file =  uniqid() . '.' . $image_type;
                $saveimage = $image->toPng()->save(public_path($imagearray_key . '/' . $file));
                $image_upload[$imagearray_key] =   $folderPath . $file;
            } else {
                $image_upload[$imagearray_key] = '';
            }
            $save_data_image = $image_upload;
        }




        return app(UpdateThemesettingsTask::class)->run($save_data_image, $request->id, $InputData);
    }
}
