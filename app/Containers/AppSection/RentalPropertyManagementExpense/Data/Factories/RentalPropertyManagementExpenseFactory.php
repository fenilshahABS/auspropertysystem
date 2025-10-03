<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Data\Factories;

use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class RentalPropertyManagementExpenseFactory extends ParentFactory
{
    protected $model = RentalPropertyManagementExpense::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
