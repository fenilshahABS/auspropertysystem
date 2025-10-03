<?php

namespace App\Containers\AppSection\Rolemaster\UI\API\Transformers;

use App\Containers\AppSection\Rolemaster\Models\Rolemaster;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class RolemasterTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Rolemaster $rolemaster): array
    {
        $response = [
            'object' => $rolemaster->getResourceKey(),
            'id' => $rolemaster->getHashedKey(),
        ];

        return $this->ifAdmin([
            'real_id' => $rolemaster->id,
            'created_at' => $rolemaster->created_at,
            'updated_at' => $rolemaster->updated_at,
            'readable_created_at' => $rolemaster->created_at->diffForHumans(),
            'readable_updated_at' => $rolemaster->updated_at->diffForHumans(),
            // 'deleted_at' => $rolemaster->deleted_at,
        ], $response);
    }
}
