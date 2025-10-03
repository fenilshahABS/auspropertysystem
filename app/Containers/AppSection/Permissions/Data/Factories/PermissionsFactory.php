<?php

namespace App\Containers\AppSection\Permissions\Data\Factories;

use App\Containers\AppSection\Permissions\Models\Permissions;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class PermissionsFactory extends ParentFactory
{
    protected $model = Permissions::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
