<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RentalPropertyManagementRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
