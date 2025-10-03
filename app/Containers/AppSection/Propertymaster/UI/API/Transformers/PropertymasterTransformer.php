<?php

namespace App\Containers\AppSection\Propertymaster\UI\API\Transformers;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Containers\AppSection\Rolemaster\Models\Rolemaster;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class PropertymasterTransformer extends ParentTransformer
{
    use HashIdTrait;
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];

    public function transform(Propertymaster $propertymaster): array
    {
        $propertymaster_details = PropertymasterDetails::where('pro_property_master_id', $propertymaster->id)->get();
        $image_api_url = Themesettings::select('image_api_url')->where('id', 1)->first();
        $returnDetails = array();
        if (!empty($propertymaster_details) && count($propertymaster_details)) {
            for ($i = 0; $i < count($propertymaster_details); $i++) {
                $returnDetails[$i]['id'] = $this->encode($propertymaster_details[$i]->id);
                $returnDetails[$i]['pro_property_master_id'] = $this->encode($propertymaster_details[$i]->pro_property_master_id);
                $returnDetails[$i]['units_name'] = $propertymaster_details[$i]->units_name;
                $returnDetails[$i]['units_beds'] = $propertymaster_details[$i]->units_beds;
                $returnDetails[$i]['units_baths'] = $propertymaster_details[$i]->units_baths;
                $returnDetails[$i]['units_size'] = $propertymaster_details[$i]->units_size;
                $returnDetails[$i]['market_rent'] = $propertymaster_details[$i]->market_rent;
                $returnDetails[$i]['property_photo_1'] = ($propertymaster_details[$i]->property_photo_1) ? $image_api_url->image_api_url . $propertymaster_details[$i]->property_photo_1 : "";
                $returnDetails[$i]['property_photo_2'] = ($propertymaster_details[$i]->property_photo_2) ? $image_api_url->image_api_url . $propertymaster_details[$i]->property_photo_2 : "";
                $returnDetails[$i]['property_photo_3'] = ($propertymaster_details[$i]->property_photo_3) ? $image_api_url->image_api_url . $propertymaster_details[$i]->property_photo_3 : "";
                $returnDetails[$i]['property_status'] = $propertymaster_details[$i]->property_status;
            }
        } else {
            $returnDetails = [];
        }
        $returnShareDetails = array();
        $propertyshare_details = PropertymasterShareDetails::where('pro_property_master_id', $propertymaster->id)->get();
        if (!empty($propertyshare_details) && count($propertyshare_details)) {
            for ($i = 0; $i < count($propertyshare_details); $i++) {
                $returnShareDetails[$i]['id'] = $this->encode($propertyshare_details[$i]->id);
                $returnShareDetails[$i]['pro_property_master_id'] = $this->encode($propertyshare_details[$i]->pro_property_master_id);
                $returnShareDetails[$i]['property_owner_id'] = $this->encode($propertyshare_details[$i]->property_owner_id);
                $returnShareDetails[$i]['ownership_share'] = $propertyshare_details[$i]->ownership_share;
            }
        } else {
            $returnShareDetails = [];
        }
        $response = [
            'object' => $propertymaster->getResourceKey(),
            'id' => $propertymaster->getHashedKey(),
            'type_id' => $this->encode($propertymaster->type_id),
            'type' => $propertymaster->type,
            'property_name' => $propertymaster->property_name,
            'firm_name' => $propertymaster->firm_name,
            'property_purchase_price' => $propertymaster->property_purchase_price,
            'property_purchase_date' => $propertymaster->property_purchase_date,
            'property_current_market_value' => $propertymaster->property_current_market_value,
            'property_owner' => $this->encode($propertymaster->property_owner),
            'property_owner_role' => Rolemaster::find($propertymaster->property_owner)->name ?? "",
            'property_owner_id' => $this->encode($propertymaster->property_owner_id),
            'property_owner_name' => Tenantusers::find($propertymaster->property_owner_id)->first_name ?? "",
            'property_owner_commission_amount' => $propertymaster->property_owner_commission_amount,
            'property_owner_commission_percentage' => $propertymaster->property_owner_commission_percentage,
            'property_address_1' => $propertymaster->property_address_1,
            'property_address_2' => $propertymaster->property_address_2,
            'property_city' => $propertymaster->property_city,
            'property_state' => $propertymaster->property_state,
            'property_country' => $propertymaster->property_country,
            'property_zipcode' => $propertymaster->property_zipcode,
            'status' => $propertymaster->status,
            'created_at' => $propertymaster->created_at,
            'updated_at' => $propertymaster->updated_at,
            'property_master_details' => $returnDetails,
            'property_share_details' => $returnShareDetails
        ];
        return $response;
        // return $this->ifAdmin([
        //     'real_id' => $propertymaster->id,
        //     'created_at' => $propertymaster->created_at,
        //     'updated_at' => $propertymaster->updated_at,
        //     'readable_created_at' => $propertymaster->created_at->diffForHumans(),
        //     'readable_updated_at' => $propertymaster->updated_at->diffForHumans(),
        //     // 'deleted_at' => $propertymaster->deleted_at,
        // ], $response);
    }
}
