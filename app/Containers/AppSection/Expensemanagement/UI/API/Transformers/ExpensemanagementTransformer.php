<?php

namespace App\Containers\AppSection\Expensemanagement\UI\API\Transformers;

use App\Containers\AppSection\Expensemanagement\Models\Expensemanagement;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class ExpensemanagementTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];

    public function transform(Expensemanagement $expensemanagement): array
    {
        $response = [
            'object' => $expensemanagement->getResourceKey(),
            'id' => $expensemanagement->getHashedKey(),
            'type' => $expensemanagement->type,
            'is_active' => $expensemanagement->is_active,
            'created_at' => $expensemanagement->created_at,
            'updated_at' => $expensemanagement->updated_at,
        ];
        return $response;
        // return $this->ifAdmin([
        //     'real_id' => $expensemanagement->id,
        //     'created_at' => $expensemanagement->created_at,
        //     'updated_at' => $expensemanagement->updated_at,
        //     'readable_created_at' => $expensemanagement->created_at->diffForHumans(),
        //     'readable_updated_at' => $expensemanagement->updated_at->diffForHumans(),
        //     // 'deleted_at' => $expensemanagement->deleted_at,
        // ], $response);
    }
}
