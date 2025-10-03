<?php

namespace App\Containers\AppSection\Expensemanagement\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class Expensemanagement extends ParentModel
{
    protected $table = 'pro_expense_management_master';
    protected $fillable = [
        'id',
        'type',
        'is_active'
    ];


    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Expensemanagement';
}
