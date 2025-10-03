<?php

namespace App\Containers\AppSection\Workermaster\Data\Factories;

use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class WorkermasterFactory extends ParentFactory
{
    protected $model = Workermaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
