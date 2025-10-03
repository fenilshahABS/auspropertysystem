<?php

namespace App\Containers\AppSection\Workermaster\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class WorkermasterRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
