<?php

namespace App\Containers\AppSection\Permissions\UI\API\Transformers;

use App\Containers\AppSection\Permissions\Models\Permissions;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class PermissionsTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Permissions $permissions): array
    {
        $response = [
            'object' => $permissions->getResourceKey(),
            'id' => $permissions->getHashedKey(),
        ];

        return $this->ifAdmin([
            'real_id' => $permissions->id,
            'created_at' => $permissions->created_at,
            'updated_at' => $permissions->updated_at,
            'readable_created_at' => $permissions->created_at->diffForHumans(),
            'readable_updated_at' => $permissions->updated_at->diffForHumans(),
            // 'deleted_at' => $permissions->deleted_at,
        ], $response);
    }
}
