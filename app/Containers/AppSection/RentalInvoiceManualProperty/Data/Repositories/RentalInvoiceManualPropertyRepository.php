<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RentalInvoiceManualPropertyRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
