<?php

namespace App\Containers\AppSection\RentalInvoice\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RentalInvoiceRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
