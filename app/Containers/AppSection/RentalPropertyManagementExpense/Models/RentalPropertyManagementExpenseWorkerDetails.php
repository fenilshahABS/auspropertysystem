<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class RentalPropertyManagementExpenseWorkerDetails extends ParentModel
{
    protected $table = 'pro_rentals_property_management_expense_worker_details';
    protected $fillable = [
        "id",
        "pro_rentals_property_management_expense_id",
        "worker_id",
        "worker_amount",
        "worker_amount_paid_status",
        "worker_amount_paid_transaction",
        "worker_amount_paid_date",
        "worker_notes",
        "worker_amount_type",
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
