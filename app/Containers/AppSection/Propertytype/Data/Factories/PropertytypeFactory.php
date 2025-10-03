<?php

namespace App\Containers\AppSection\Propertytype\Data\Factories;

use App\Containers\AppSection\Propertytype\Models\Propertytype;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class PropertytypeFactory extends ParentFactory
{
    protected $model = Propertytype::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
