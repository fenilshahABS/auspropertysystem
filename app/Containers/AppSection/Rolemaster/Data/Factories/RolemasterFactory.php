<?php

namespace App\Containers\AppSection\Rolemaster\Data\Factories;

use App\Containers\AppSection\Rolemaster\Models\Rolemaster;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class RolemasterFactory extends ParentFactory
{
    protected $model = Rolemaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
