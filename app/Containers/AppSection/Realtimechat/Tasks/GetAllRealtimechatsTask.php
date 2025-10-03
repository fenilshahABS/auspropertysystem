<?php

namespace App\Containers\AppSection\Realtimechat\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Realtimechat\Data\Repositories\RealtimechatRepository;
use App\Containers\AppSection\Realtimechat\Models\Realtimechat;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRealtimechatsTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RealtimechatRepository $repository
    ) {
    }


    public function run($InputData)
    {
        try {
            $returnData = array();
            $to_user_id = $this->decode($InputData->getToUserId());
            $getData = Realtimechat::where('to_user_id', $to_user_id)->orderBy('created_at', 'DESC')->paginate(50);
            $image_api_url = Themesettings::select('image_api_url')->where('id', 1)->first();
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['object'] = "pro_chatting_internally";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['to_user_id'] = $this->encode($getData[$i]->to_user_id);
                    $returnData['data'][$i]['type'] = $getData[$i]->type;
                    $returnData['data'][$i]['message'] = $getData[$i]->message;
                    $returnData['data'][$i]['image'] = ($getData[$i]->image) ? $image_api_url->image_api_url . $getData[$i]->image : "";
                    $returnData['data'][$i]['chatting_date_time'] = $getData[$i]->chatting_date_time;
                    $returnData['data'][$i]['status'] = $getData[$i]->status;
                    $returnData['data'][$i]['sender_type'] = $this->encode($getData[$i]->sender_type);
                    $returnData['data'][$i]['sent_user_id'] =  $this->encode($getData[$i]->sent_user_id);
                    $returnData['data'][$i]['sent_user_name'] = $getData[$i]->sent_user_name;
                    $returnData['data'][$i]['view_system_user_id'] =  $this->encode($getData[$i]->view_system_user_id);
                    $returnData['data'][$i]['view_system_user_name'] = $getData[$i]->view_system_user_name;
                    $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
                    $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;
                }
                $returnData['meta']['pagination']['total'] = $getData->total();
                $returnData['meta']['pagination']['count'] = $getData->count();
                $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            } else {
                $returnData = [
                    'message' => 'Data Not Found',
                    'object' => 'pro_chatting_internally',
                    'data' => [],
                ];
                $returnData['meta']['pagination']['total'] = $getData->total();
                $returnData['meta']['pagination']['count'] = $getData->count();
                $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            }
            return $returnData;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
