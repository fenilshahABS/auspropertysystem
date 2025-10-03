<?php

namespace App\Containers\AppSection\TaskManagement\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class TaskManagementRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
