<?php

namespace App\Containers\AppSection\RentalPropertyManagement\UI\API\Transformers;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagementLateFees;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class RentalPropertyManagementTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];
    use HashIdTrait;
    public function transform(RentalPropertyManagement $rentalpropertymanagement): array
    {
        $image_api_url = Themesettings::select('image_api_url')->where('id', 1)->first();

        $rentalpropertymanagement_late_fees = RentalPropertyManagementLateFees::where('pro_rentals_property_management_id', $rentalpropertymanagement->id)->get();
        $returnDetails = array();
        if (!empty($rentalpropertymanagement_late_fees) && count($rentalpropertymanagement_late_fees)) {
            for ($i = 0; $i < count($rentalpropertymanagement_late_fees); $i++) {
                $returnDetails[$i]['id'] = $this->encode($rentalpropertymanagement_late_fees[$i]->id);
                $returnDetails[$i]['pro_rentals_property_management_id'] = $this->encode($rentalpropertymanagement_late_fees[$i]->pro_rentals_property_management_id);
                $returnDetails[$i]['date_range_type'] = $rentalpropertymanagement_late_fees[$i]->date_range_type;
                $returnDetails[$i]['date_range_value'] = $rentalpropertymanagement_late_fees[$i]->date_range_value;
                $returnDetails[$i]['late_fees_amount'] = $rentalpropertymanagement_late_fees[$i]->late_fees_amount;
            }
        } else {
            $returnDetails = [];
        }
        $property_default_rent = Propertymaster::find($rentalpropertymanagement->property_master_id)->property_owner_commission_amount;

        $response = [
            'object' => $rentalpropertymanagement->getResourceKey(),
            'id' => $rentalpropertymanagement->getHashedKey(),
            'property_master_id' => $this->encode($rentalpropertymanagement->property_master_id),
            'pro_property_master_details_id' => $this->encode($rentalpropertymanagement->pro_property_master_details_id),
            'lease_start_date' => $rentalpropertymanagement->lease_start_date,
            'lease_end_date' => $rentalpropertymanagement->lease_end_date,
            'user_id' => $this->encode($rentalpropertymanagement->user_id),
            'rent_date' => $rentalpropertymanagement->rent_date,
            'rent_frequency' => $rentalpropertymanagement->rent_frequency,
            'property_default_rent' => $property_default_rent,
            'rent_amount' => $rentalpropertymanagement->rent_amount,
            'security_deposit' => $rentalpropertymanagement->security_deposit,
            'advance_amount' => $rentalpropertymanagement->advance_amount,
            'late_fees' => $rentalpropertymanagement->late_fees,
            'lease_document' => ($rentalpropertymanagement->lease_document) ? $image_api_url->image_api_url . $rentalpropertymanagement->lease_document : "",
            'rentalpropertymanagement_late_fees' => $returnDetails
        ];

        return $response;
        // return $this->ifAdmin([
        //     'real_id' => $rentalpropertymanagement->id,
        //     'created_at' => $rentalpropertymanagement->created_at,
        //     'updated_at' => $rentalpropertymanagement->updated_at,
        //     'readable_created_at' => $rentalpropertymanagement->created_at->diffForHumans(),
        //     'readable_updated_at' => $rentalpropertymanagement->updated_at->diffForHumans(),
        // ], $response);

    }
}
