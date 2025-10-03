<?php

namespace App\Containers\AppSection\Realtimechat\Actions;

use App\Containers\AppSection\Realtimechat\Models\Realtimechat;
use App\Containers\AppSection\Realtimechat\Tasks\RealtimechatCountsTask;
use App\Containers\AppSection\Realtimechat\UI\API\Requests\GetAllRealtimechatsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class RealtimechatCountsAction extends ParentAction
{

    public function run(GetAllRealtimechatsRequest $request, $InputData)
    {
        return app(RealtimechatCountsTask::class)->run($InputData);
    }
}
