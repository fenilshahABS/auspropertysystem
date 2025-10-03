<?php

namespace App\Containers\AppSection\Themesettings\UI\API\Transformers;

use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class ThemesettingsTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Themesettings $themesettings): array
    {
        $response = [
            'object' => $themesettings->getResourceKey(),
            'id' => $themesettings->getHashedKey(),
        ];

        return $this->ifAdmin([
            'real_id' => $themesettings->id,
            'created_at' => $themesettings->created_at,
            'updated_at' => $themesettings->updated_at,
            'readable_created_at' => $themesettings->created_at->diffForHumans(),
            'readable_updated_at' => $themesettings->updated_at->diffForHumans(),
            // 'deleted_at' => $themesettings->deleted_at,
        ], $response);
    }
}
