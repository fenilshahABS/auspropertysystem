<?php

namespace App\Containers\AppSection\Propertymaster\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class PropertymasterRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
