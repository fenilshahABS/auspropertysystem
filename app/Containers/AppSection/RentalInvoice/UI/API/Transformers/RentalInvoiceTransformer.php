<?php

namespace App\Containers\AppSection\RentalInvoice\UI\API\Transformers;

use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class RentalInvoiceTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(RentalInvoice $rentalinvoice): array
    {
        $response = [
            'object' => $rentalinvoice->getResourceKey(),
            'id' => $rentalinvoice->getHashedKey(),
        ];

        return $this->ifAdmin([
            'real_id' => $rentalinvoice->id,
            'created_at' => $rentalinvoice->created_at,
            'updated_at' => $rentalinvoice->updated_at,
            'readable_created_at' => $rentalinvoice->created_at->diffForHumans(),
            'readable_updated_at' => $rentalinvoice->updated_at->diffForHumans(),
            // 'deleted_at' => $rentalinvoice->deleted_at,
        ], $response);
    }
}
