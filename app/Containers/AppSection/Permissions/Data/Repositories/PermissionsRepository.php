<?php

namespace App\Containers\AppSection\Permissions\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class PermissionsRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
