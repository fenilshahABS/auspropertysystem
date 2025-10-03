<?php

namespace App\Containers\AppSection\Notifications\Data\Factories;

use App\Containers\AppSection\Notifications\Models\Notifications;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class NotificationsFactory extends ParentFactory
{
    protected $model = Notifications::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
