<?php

namespace App\Containers\AppSection\Realtimechat\Actions;

use App\Containers\AppSection\Realtimechat\Tasks\DeleteRealtimechatTask;
use App\Containers\AppSection\Realtimechat\UI\API\Requests\DeleteRealtimechatRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteRealtimechatAction extends ParentAction
{
    /**
     * @param DeleteRealtimechatRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteRealtimechatRequest $request): int
    {
        return app(DeleteRealtimechatTask::class)->run($request->id);
    }
}
