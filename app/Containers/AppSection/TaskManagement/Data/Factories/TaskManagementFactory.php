<?php

namespace App\Containers\AppSection\TaskManagement\Data\Factories;

use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class TaskManagementFactory extends ParentFactory
{
    protected $model = TaskManagement::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
