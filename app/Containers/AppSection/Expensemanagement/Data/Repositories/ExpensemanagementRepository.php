<?php

namespace App\Containers\AppSection\Expensemanagement\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class ExpensemanagementRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
