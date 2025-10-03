<?php

namespace App\Containers\AppSection\Tenantusers\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class TenantusersRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
