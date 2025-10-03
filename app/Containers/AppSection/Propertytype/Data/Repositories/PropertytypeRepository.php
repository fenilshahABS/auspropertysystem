<?php

namespace App\Containers\AppSection\Propertytype\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class PropertytypeRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
