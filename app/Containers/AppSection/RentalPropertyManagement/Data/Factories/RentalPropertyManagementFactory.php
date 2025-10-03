<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Data\Factories;

use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class RentalPropertyManagementFactory extends ParentFactory
{
    protected $model = RentalPropertyManagement::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
