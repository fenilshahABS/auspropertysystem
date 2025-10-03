<?php

namespace App\Containers\AppSection\Propertyreports\UI\API\Transformers;

use App\Containers\AppSection\Propertyreports\Models\Propertyreports;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class PropertyreportsTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Propertyreports $propertyreports): array
    {
        $response = [
            'object' => $propertyreports->getResourceKey(),
            'id' => $propertyreports->getHashedKey(),
        ];

        return $this->ifAdmin([
            'real_id' => $propertyreports->id,
            'created_at' => $propertyreports->created_at,
            'updated_at' => $propertyreports->updated_at,
            'readable_created_at' => $propertyreports->created_at->diffForHumans(),
            'readable_updated_at' => $propertyreports->updated_at->diffForHumans(),
            // 'deleted_at' => $propertyreports->deleted_at,
        ], $response);
    }
}
