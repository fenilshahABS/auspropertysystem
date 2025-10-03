<?php

namespace App\Containers\AppSection\Propertymaster\Data\Factories;

use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class PropertymasterFactory extends ParentFactory
{
    protected $model = Propertymaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
