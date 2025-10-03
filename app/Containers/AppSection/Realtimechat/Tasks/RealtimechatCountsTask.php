<?php

namespace App\Containers\AppSection\Realtimechat\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Realtimechat\Data\Repositories\RealtimechatRepository;
use App\Containers\AppSection\Realtimechat\Models\Realtimechat;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class RealtimechatCountsTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RealtimechatRepository $repository
    ) {
    }

    public function run($InputData)
    {
        //  try {
        $returnData = array();
        $to_user_id = $this->decode($InputData->getToUserId());

        if ($to_user_id != "") {
            $getData = Realtimechat::where('to_user_id', $to_user_id)->where('sender_type', 1)->where('status', 0)->count();
            $returnData['message'] = "Data Found";
            $returnData['data']['object'] = "pro_chatting_internally";
            $returnData['data']['chat_count'] = $getData;
        } else {
            $getData = Tenantusers::whereIn('role_id', [2, 3])->get();
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['object'] = "pro_chatting_internally";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['first_name'] = $getData[$i]->first_name;
                    $returnData['data'][$i]['last_name'] = $getData[$i]->last_name;
                    $returnData['data'][$i]['email'] = $getData[$i]->email;
                    $returnData['data'][$i]['mobile'] = $getData[$i]->mobile;
                    $chat_count = Realtimechat::where('to_user_id', $getData[$i]->id)->whereIn('sender_type', [2, 3])->where('status', 0)->count();
                    $returnData['data'][$i]['chat_count'] = $chat_count;
                }
                // $returnData['meta']['pagination']['total'] = $getData->total();
                // $returnData['meta']['pagination']['count'] = $getData->count();
                // $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                // $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                // $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                // $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                // $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            } else {
                $returnData = [
                    'message' => 'Data Not Found',
                    'object' => 'pro_chatting_internally',
                    'data' => [],
                ];
                // $returnData['meta']['pagination']['total'] = $getData->total();
                // $returnData['meta']['pagination']['count'] = $getData->count();
                // $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                // $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                // $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                // $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                // $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            }
        }
        return $returnData;
        // } catch (\Throwable $th) {
        //     throw $th;
        // }
    }
}
