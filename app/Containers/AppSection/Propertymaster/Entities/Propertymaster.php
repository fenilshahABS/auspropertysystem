<?php

namespace App\Containers\AppSection\Propertymaster\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jp_tenantusers")
 */
class Propertymaster
{
    protected $firm_name;
    protected $type_id;
    protected $property_name;
    protected $type;
    protected $property_owner;
    protected $property_owner_id;
    protected $property_master_details;
    protected $property_owner_commission_percentage;
    protected $property_owner_commission_amount;
    protected $property_address_1;
    protected $property_address_2;
    protected $property_city;
    protected $property_state;
    protected $property_country;
    protected $property_zipcode;
    protected $status;
    protected $property_share;

    protected $pro_property_master_id;
    protected $pro_property_master_details_id;
    protected $ownership_share;
    protected $units_name;
    protected $units_beds;
    protected $units_baths;
    protected $units_size;
    protected $market_rent;
    protected $property_photo_1;
    protected $property_photo_2;
    protected $property_photo_3;
    protected $property_status;

    protected $property_purchase_price;
    protected $property_purchase_date;
    protected $property_current_market_value;

    protected $user_id;

    protected $flag;
    protected $search_val;
    protected $field_db;
    protected $per_page;

    public function __construct($request = null)
    {
        $this->firm_name = isset($request['firm_name']) ? $request['firm_name'] : null;
        $this->user_id = isset($request['user_id']) ? $request['user_id'] : null;
        $this->property_purchase_price = isset($request['property_purchase_price']) ? $request['property_purchase_price'] : null;
        $this->property_purchase_date = isset($request['property_purchase_date']) ? $request['property_purchase_date'] : null;
        $this->property_current_market_value = isset($request['property_current_market_value']) ? $request['property_current_market_value'] : null;
        $this->property_name = isset($request['property_name']) ? $request['property_name'] : null;
        $this->pro_property_master_details_id = isset($request['pro_property_master_details_id']) ? $request['pro_property_master_details_id'] : null;
        $this->ownership_share = isset($request['ownership_share']) ? $request['ownership_share'] : null;
        $this->type_id = isset($request['type_id']) ? $request['type_id'] : null;
        $this->type = isset($request['type']) ? $request['type'] : null;
        $this->property_owner = isset($request['property_owner']) ? $request['property_owner'] : null;
        $this->property_master_details = isset($request['property_master_details']) ? $request['property_master_details'] : null;
        $this->property_owner_id = isset($request['property_owner_id']) ? $request['property_owner_id'] : null;
        $this->property_owner_commission_percentage = isset($request['property_owner_commission_percentage']) ? $request['property_owner_commission_percentage'] : null;
        $this->property_owner_commission_amount = isset($request['property_owner_commission_amount']) ? $request['property_owner_commission_amount'] : null;
        $this->property_address_1 = isset($request['property_address_1']) ? $request['property_address_1'] : null;
        $this->property_address_2 = isset($request['property_address_2']) ? $request['property_address_2'] : null;
        $this->property_city = isset($request['property_city']) ? $request['property_city'] : null;
        $this->property_state = isset($request['property_state']) ? $request['property_state'] : null;
        $this->property_country = isset($request['property_country']) ? $request['property_country'] : null;
        $this->property_zipcode = isset($request['property_zipcode']) ? $request['property_zipcode'] : null;
        $this->status = isset($request['status']) ? $request['status'] : null;

        $this->pro_property_master_id = isset($request['pro_property_master_id']) ? $request['pro_property_master_id'] : null;
        $this->units_name             = isset($request['units_name']) ? $request['units_name'] : null;
        $this->units_beds             = isset($request['units_beds']) ? $request['units_beds'] : null;
        $this->units_baths            = isset($request['units_baths']) ? $request['units_baths'] : null;
        $this->units_size             = isset($request['units_size']) ? $request['units_size'] : null;
        $this->market_rent            = isset($request['market_rent']) ? $request['market_rent'] : null;
        $this->property_photo_1       = isset($request['property_photo_1']) ? $request['property_photo_1'] : null;
        $this->property_photo_2       = isset($request['property_photo_2']) ? $request['property_photo_2'] : null;
        $this->property_photo_3       = isset($request['property_photo_3']) ? $request['property_photo_3'] : null;
        $this->property_status        = isset($request['property_status']) ? $request['property_status'] : null;
        $this->property_share        = isset($request['property_share']) ? $request['property_share'] : null;

        $this->flag =  isset($request['flag']) ? $request['flag'] : null;
        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->per_page = isset($request['per_page']) ? $request['per_page'] : null;
    }

    public function getUserID()
    {
        return $this->user_id;
    }
    public function getPropertyPurchasePrice()
    {
        return $this->property_purchase_price;
    }
    public function getPropertyPurchaseDate()
    {
        return $this->property_purchase_date;
    }
    public function getPropertyCurrentMarketValue()
    {
        return $this->property_current_market_value;
    }
    public function getFirmName()
    {
        return $this->firm_name;
    }

    public function getPropertyName()
    {
        return $this->property_name;
    }

    public function getProPropertyMasterDetailsId()
    {
        return $this->pro_property_master_details_id;
    }
    public function getPropertyShare()
    {
        return $this->property_share;
    }

    public function getOwnershipShare()
    {
        return $this->ownership_share;
    }

    public function getTypeId()
    {
        return $this->type_id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getPropertyMasterDetails()
    {
        return $this->property_master_details;
    }
    public function getPropertyOwner()
    {
        return $this->property_owner;
    }

    public function getPropertyOwnerId()
    {
        return $this->property_owner_id;
    }

    public function getPropertyOwnerCommissionAmount()
    {
        return $this->property_owner_commission_amount;
    }

    public function getPropertyOwnerCommissionPercentage()
    {
        return $this->property_owner_commission_percentage;
    }

    public function getPropertyAddress1()
    {
        return $this->property_address_1;
    }

    public function getPropertyAddress2()
    {
        return $this->property_address_2;
    }

    public function getPropertyCity()
    {
        return $this->property_city;
    }

    public function getPropertyState()
    {
        return $this->property_state;
    }

    public function getPropertyCountry()
    {
        return $this->property_country;
    }

    public function getPropertyZipcode()
    {
        return $this->property_zipcode;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getFlag()
    {
        return $this->flag;
    }

    public function getProPropertyMasterId()
    {
        return $this->pro_property_master_id;
    }

    public function getUnitsName()
    {
        return $this->units_name;
    }

    public function getUnitsBeds()
    {
        return $this->units_beds;
    }

    public function getUnitsBaths()
    {
        return $this->units_baths;
    }

    public function getUnitsSize()
    {
        return $this->units_size;
    }

    public function getMarketRent()
    {
        return $this->market_rent;
    }

    public function getPropertyPhoto1()
    {
        return $this->property_photo_1;
    }

    public function getPropertyPhoto2()
    {
        return $this->property_photo_2;
    }

    public function getPropertyPhoto3()
    {
        return $this->property_photo_3;
    }

    public function getPropertyStatus()
    {
        return $this->property_status;
    }




    public function getSearchVal()
    {
        return $this->search_val;
    }

    public function getFieldDB()
    {
        return $this->field_db;
    }

    public function getPerPage()
    {
        return $this->per_page;
    }
}
