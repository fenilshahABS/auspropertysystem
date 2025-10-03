<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class RentalPropertyManagementExpense extends ParentModel
{
    protected $table = 'pro_rentals_property_management_expense';
    protected $fillable = [
        "id",
        "pro_rentals_property_management_id",
        "status",
        "total_amount",
        "amount_receive_status",
        "amount_receive_transaction",
        "amount_recieve_date",
        "amount_commission",
        "amount_type",
        "due_date",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'RentalPropertyManagementExpense';
}
