<?php

namespace App\Containers\AppSection\Propertymaster\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Tasks\CreatePropertymasterTask;
use App\Containers\AppSection\Propertymaster\UI\API\Requests\CreatePropertymasterRequest;
use App\Containers\AppSection\Propertytype\Models\Propertytype;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CreatePropertymasterAction extends ParentAction
{
    use HashIdTrait;
    public function run(CreatePropertymasterRequest $request, $InputData)
    {
        $type_id = $this->decode($InputData->getTypeId());
        $property_owner_id = $this->decode($InputData->getPropertyOwnerId());
        $property_owner = $this->decode($InputData->getPropertyOwner());
        $data = $request->sanitizeInput([
            // "type" => Propertytype::find($type_id)->type,
            "firm_name" => $InputData->getFirmName(),
            "property_purchase_price" => $InputData->getPropertyPurchasePrice(),
            "property_purchase_date" => $InputData->getPropertyPurchaseDate(),
            "property_current_market_value" => $InputData->getPropertyCurrentMarketValue(),
            "property_name" => $InputData->getPropertyName(),
            "property_owner_commission_amount" => $InputData->getPropertyOwnerCommissionAmount(),
            "property_owner_commission_percentage" => $InputData->getPropertyOwnerCommissionPercentage(),
            "property_address_1" => $InputData->getPropertyAddress1(),
            "property_address_2" => $InputData->getPropertyAddress2(),
            "property_city" => $InputData->getPropertyCity(),
            "property_state" => $InputData->getPropertyState(),
            "property_country" => $InputData->getPropertyCountry(),
            "property_zipcode" => $InputData->getPropertyZipcode(),
            "status" => $InputData->getStatus(),
        ]);
        $data['type_id'] = $type_id;
        // $data['property_owner_id'] = $property_owner_id;
        $data['property_owner'] = $property_owner;
        $data['type'] = Propertytype::find($type_id)->type;
        $property_master_details = $InputData->getPropertyMasterDetails();
        for ($i = 0; $i < count($property_master_details); $i++) {

            $imagearray = array();
            $imagearray['property_photo_1'] = $property_master_details[$i]['property_photo_1'];
            $imagearray['property_photo_2'] = $property_master_details[$i]['property_photo_2'];
            $imagearray['property_photo_3'] = $property_master_details[$i]['property_photo_3'];
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

            $master_details[$i] = [
                "units_name" => $property_master_details[$i]['units_name'],
                "units_beds" => $property_master_details[$i]['units_beds'],
                "units_baths" => $property_master_details[$i]['units_baths'],
                "units_size" => $property_master_details[$i]['units_size'],
                "market_rent" => $property_master_details[$i]['market_rent'],
                "property_photo_1" => $save_data_image['property_photo_1'],
                "property_photo_2" => $save_data_image['property_photo_2'],
                "property_photo_3" => $save_data_image['property_photo_3'],
                "property_status" => $property_master_details[$i]['property_status']
            ];
        }
        $property_share_details = $InputData->getPropertyShare();

        for ($j = 0; $j < count($property_share_details); $j++) {

            $share_details[$j] = [
                "property_owner_id" => $this->decode($property_share_details[$j]['property_owner_id']),
                "ownership_share" => $property_share_details[$j]['ownership_share'],
            ];
        }



        return app(CreatePropertymasterTask::class)->run($data, $master_details, $share_details);
    }
}
