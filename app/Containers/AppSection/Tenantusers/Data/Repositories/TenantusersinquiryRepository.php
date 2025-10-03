<?php

namespace App\Containers\AppSection\Tenantusers\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class TenantusersinquiryRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
