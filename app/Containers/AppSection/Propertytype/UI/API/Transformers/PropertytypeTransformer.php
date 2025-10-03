<?php

namespace App\Containers\AppSection\Propertytype\UI\API\Transformers;

use App\Containers\AppSection\Propertytype\Models\Propertytype;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class PropertytypeTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];

    public function transform(Propertytype $propertytype): array
    {

        $response = [
            'object' => $propertytype->getResourceKey(),
            'id' => $propertytype->getHashedKey(),
            'type' => $propertytype->type,
            'is_active' => $propertytype->is_active,
            'created_at' => $propertytype->created_at,
            'updated_at' => $propertytype->updated_at,

        ];
        return $response;
        // return $this->ifAdmin([
        //     'real_id' => $propertytype->id,
        //     'created_at' => $propertytype->created_at,
        //     'updated_at' => $propertytype->updated_at,
        //     'readable_created_at' => $propertytype->created_at->diffForHumans(),
        //     'readable_updated_at' => $propertytype->updated_at->diffForHumans(),
        //     // 'deleted_at' => $propertytype->deleted_at,
        // ], $response);
    }
}
