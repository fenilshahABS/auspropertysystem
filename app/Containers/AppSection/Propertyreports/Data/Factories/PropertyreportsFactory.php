<?php

namespace App\Containers\AppSection\Propertyreports\Data\Factories;

use App\Containers\AppSection\Propertyreports\Models\Propertyreports;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class PropertyreportsFactory extends ParentFactory
{
    protected $model = Propertyreports::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
