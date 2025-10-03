<?php

namespace App\Containers\AppSection\RentalInvoice\Data\Factories;

use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class RentalInvoiceFactory extends ParentFactory
{
    protected $model = RentalInvoice::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
