<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Data\Factories;

use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class RentalInvoiceManualFactory extends ParentFactory
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
