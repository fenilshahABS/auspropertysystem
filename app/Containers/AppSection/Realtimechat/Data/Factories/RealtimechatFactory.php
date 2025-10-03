<?php

namespace App\Containers\AppSection\Realtimechat\Data\Factories;

use App\Containers\AppSection\Realtimechat\Models\Realtimechat;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class RealtimechatFactory extends ParentFactory
{
    protected $model = Realtimechat::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
