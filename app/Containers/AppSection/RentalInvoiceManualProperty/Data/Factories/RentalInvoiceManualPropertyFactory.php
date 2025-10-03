<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Data\Factories;

use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class RentalInvoiceManualPropertyFactory extends ParentFactory
{
    protected $model = RentalInvoiceManual::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
