<?php

namespace App\Containers\AppSection\Realtimechat\UI\API\Transformers;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Realtimechat\Models\Realtimechat;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class RealtimechatTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];
    use HashIdTrait;
    public function transform(Realtimechat $realtimechat): array
    {
        $image_api_url = Themesettings::select('image_api_url')->where('id', 1)->first();
        $response = [
            'object' => $realtimechat->getResourceKey(),
            'id' => $realtimechat->getHashedKey(),
            'to_user_id' => $this->encode($realtimechat->to_user_id),
            'type' => $realtimechat->type,
            'message' => $realtimechat->message,
            'image' => ($realtimechat->image) ? $image_api_url->image_api_url . $realtimechat->image : "",
            'chatting_date_time' => $realtimechat->chatting_date_time,
            'status' => $realtimechat->status,
            'sender_type' => $realtimechat->sender_type,
            'sent_user_id' => $this->encode($realtimechat->sent_user_id),
            'sent_user_name' => $realtimechat->sent_user_name,
            'view_system_user_id' => $this->encode($realtimechat->view_system_user_id),
            'view_system_user_name' => $realtimechat->view_system_user_name,
            'created_at' => $realtimechat->created_at,
            'updated_at' => $realtimechat->updated_at,
            'deleted_at' => $realtimechat->deleted_at,
        ];

        return $response;
        // return $this->ifAdmin([
        //     'real_id' => $realtimechat->id,
        //     'created_at' => $realtimechat->created_at,
        //     'updated_at' => $realtimechat->updated_at,
        //     'readable_created_at' => $realtimechat->created_at->diffForHumans(),
        //     'readable_updated_at' => $realtimechat->updated_at->diffForHumans(),
        //     // 'deleted_at' => $realtimechat->deleted_at,
        // ], $response);
    }
}
