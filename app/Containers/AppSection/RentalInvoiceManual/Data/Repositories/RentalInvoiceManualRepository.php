<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RentalInvoiceManualRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
