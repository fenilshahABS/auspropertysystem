<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Entities;

use Doctrine\ORM\Mapping as ORM;


class RentalPropertyManagement
{
    protected $property_master_id;
    protected $pro_property_master_details_id;
    protected $lease_start_date;
    protected $lease_end_date;
    protected $user_id;
    protected $rent_date;
    protected $rent_frequency;
    protected $rent_amount;
    protected $security_deposit;
    protected $advance_amount;
    protected $late_fees;
    protected $lease_document;
    protected $pro_rentals_property_management_id;
    protected $date_range_type;
    protected $date_range_value;
    protected $late_fees_amount;
    protected $late_fees_details;

    protected $search_val;
    protected $field_db;
    protected $per_page;

    public function __construct($request = null)
    {

        $this->late_fees_details           = isset($request['late_fees_details']) ? $request['late_fees_details'] : null;
        $this->property_master_id           = isset($request['property_master_id']) ? $request['property_master_id'] : null;
        $this->pro_property_master_details_id = isset($request['pro_property_master_details_id']) ? $request['pro_property_master_details_id'] : null;
        $this->lease_start_date             = isset($request['lease_start_date']) ? $request['lease_start_date'] : null;
        $this->lease_end_date               = isset($request['lease_end_date']) ? $request['lease_end_date'] : null;
        $this->user_id                      = isset($request['user_id']) ? $request['user_id'] : null;
        $this->rent_date                    = isset($request['rent_date']) ? $request['rent_date'] : null;
        $this->rent_frequency               = isset($request['rent_frequency']) ? $request['rent_frequency'] : null;
        $this->rent_amount                  = isset($request['rent_amount']) ? $request['rent_amount'] : null;
        $this->security_deposit             = isset($request['security_deposit']) ? $request['security_deposit'] : null;
        $this->advance_amount               = isset($request['advance_amount']) ? $request['advance_amount'] : null;
        $this->late_fees                    = isset($request['late_fees']) ? $request['late_fees'] : null;
        $this->lease_document               = isset($request['lease_document']) ? $request['lease_document'] : null;
        $this->pro_rentals_property_management_id = isset($request['pro_rentals_property_management_id']) ? $request['pro_rentals_property_management_id'] : null;
        $this->date_range_type                   = isset($request['date_range_type']) ? $request['date_range_type'] : null;
        $this->date_range_value                  = isset($request['date_range_value']) ? $request['date_range_value'] : null;
        $this->late_fees_amount                  = isset($request['late_fees_amount']) ? $request['late_fees_amount'] : null;

        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->per_page = isset($request['per_page']) ? $request['per_page'] : null;
    }

    public function getLateFeesDetails()
    {
        return $this->late_fees_details;
    }

    public function getProRentalsPropertyManagementId()
    {
        return $this->pro_rentals_property_management_id;
    }

    public function getDateRangeType()
    {
        return $this->date_range_type;
    }

    public function getDateRangeValue()
    {
        return $this->date_range_value;
    }

    public function getLateFeesAmount()
    {
        return $this->late_fees_amount;
    }

    public function getPropertyMasterId()
    {
        return $this->property_master_id;
    }

    public function getProPropertyMasterDetailsId()
    {
        return $this->pro_property_master_details_id;
    }

    public function getLeaseStartDate()
    {
        return $this->lease_start_date;
    }

    public function getLeaseEndDate()
    {
        return $this->lease_end_date;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getRentDate()
    {
        return $this->rent_date;
    }

    public function getRentFrequency()
    {
        return $this->rent_frequency;
    }

    public function getRentAmount()
    {
        return $this->rent_amount;
    }

    public function getSecurityDeposit()
    {
        return $this->security_deposit;
    }

    public function getAdvanceAmount()
    {
        return $this->advance_amount;
    }

    public function getLateFees()
    {
        return $this->late_fees;
    }

    public function getLeaseDocument()
    {
        return $this->lease_document;
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
