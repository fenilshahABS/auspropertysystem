<?php

namespace App\Containers\AppSection\Rolemaster\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RolemasterRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
