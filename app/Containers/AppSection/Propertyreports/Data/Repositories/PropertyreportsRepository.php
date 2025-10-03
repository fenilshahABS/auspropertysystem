<?php

namespace App\Containers\AppSection\Propertyreports\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class PropertyreportsRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
