<?php

namespace App\Containers\AppSection\Themesettings\Data\Factories;

use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class ThemesettingsFactory extends ParentFactory
{
    protected $model = Themesettings::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
