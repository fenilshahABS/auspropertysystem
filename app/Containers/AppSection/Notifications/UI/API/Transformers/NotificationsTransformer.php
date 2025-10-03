<?php

namespace App\Containers\AppSection\Notifications\UI\API\Transformers;

use App\Containers\AppSection\Notifications\Models\Notifications;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class NotificationsTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];

    public function transform(Notifications $notifications): array
    {
        $response = [
            'object' => $notifications->getResourceKey(),
            'id' => $notifications->getHashedKey(),
        ];

        return $this->ifAdmin([
            'real_id' => $notifications->id,
            'created_at' => $notifications->created_at,
            'updated_at' => $notifications->updated_at,
            'readable_created_at' => $notifications->created_at->diffForHumans(),
            'readable_updated_at' => $notifications->updated_at->diffForHumans(),
            // 'deleted_at' => $notifications->deleted_at,
        ], $response);
    }
}
