<?php

namespace App\Containers\AppSection\Expensemanagement\Data\Factories;

use App\Containers\AppSection\Expensemanagement\Models\Expensemanagement;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class ExpensemanagementFactory extends ParentFactory
{
    protected $model = Expensemanagement::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
