<?php

namespace App\Containers\AppSection\Notifications\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Notifications\Data\Repositories\NotificationsRepository;
use App\Containers\AppSection\Notifications\Models\Notifications;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;

class FindNotificationsByUserIdTask extends ParentTask
{
    use HashIdTrait;
    protected NotificationsRepository $repository;
    public function __construct(NotificationsRepository $repository)
    {
        $this->repository = $repository;
    }


    public function run($id)
    {
        // try {
        $returnData = array();
        $getData = Notifications::where('user_to_notify', $id)->where('is_seen', 0)->orderBy('created_at', 'DESC')->get();

        if ($getData != "" && count($getData) >= 1) {
            $returnData['result'] = true;
            $returnData['message'] = "Data Found";
            $returnData['object'] = "pro_notifications";
            for ($i = 0; $i < count($getData); $i++) {
                $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                $returnData['data'][$i]['user_to_notify'] = $this->encode($getData[$i]->user_to_notify);
                $returnData['data'][$i]['user_who_fired_event'] = $this->encode($getData[$i]->user_who_fired_event);
                $returnData['data'][$i]['message'] = $getData[$i]->message;
                $returnData['data'][$i]['is_seen'] = $getData[$i]->is_seen;
                $returnData['data'][$i]['module'] = $getData[$i]->module;
                $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
                $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;
            }
        } else {
            $returnData['result'] = false;
            $returnData['message'] = "Data not found";
            $returnData['object'] = "pro_notifications";
            $returnData['data'] = [];
        }
        return $returnData;
        // } catch (Exception $e) {
        //     return [
        //         'result' => false,
        //         'message' => 'Error: Failed to find the resource. Please try again later.',
        //         'object' => 'pro_notifications',
        //         'data' => [],
        //     ];
        // }
    }
}
