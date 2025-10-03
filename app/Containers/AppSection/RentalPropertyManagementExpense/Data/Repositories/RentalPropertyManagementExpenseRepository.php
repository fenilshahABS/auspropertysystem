<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RentalPropertyManagementExpenseRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
