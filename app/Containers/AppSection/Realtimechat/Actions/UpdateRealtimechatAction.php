<?php

namespace App\Containers\AppSection\Realtimechat\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Realtimechat\Models\Realtimechat;
use App\Containers\AppSection\Realtimechat\Tasks\UpdateRealtimechatTask;
use App\Containers\AppSection\Realtimechat\UI\API\Requests\UpdateRealtimechatRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateRealtimechatAction extends ParentAction
{
    use HashIdTrait;
    public function run(UpdateRealtimechatRequest $request, $InputData)
    {

        return app(UpdateRealtimechatTask::class)->run($InputData, $request->id);
    }
}
