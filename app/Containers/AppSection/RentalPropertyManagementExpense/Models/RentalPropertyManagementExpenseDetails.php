<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class RentalPropertyManagementExpenseDetails extends ParentModel
{
    protected $table = 'pro_rentals_property_management_expense_details';
    protected $fillable = [
        "id",
        "pro_rentals_property_management_expense_id",
        "expense_management_master_id",
        "amount",
        "property_damage_image_1",
        "property_damage_image_2",
        "description",
        "is_tax_applied",
        "tax",
        "tax_amount",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'RentalPropertyManagementExpenseDetails';
}
