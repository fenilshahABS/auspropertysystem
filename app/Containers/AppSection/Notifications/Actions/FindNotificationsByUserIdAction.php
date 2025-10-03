<?php

namespace App\Containers\AppSection\Notifications\Actions;

use App\Containers\AppSection\Notifications\Models\Notifications;
use App\Containers\AppSection\Notifications\Tasks\FindNotificationsByUserIdTask;
use App\Containers\AppSection\Notifications\UI\API\Requests\FindNotificationsByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindNotificationsByUserIdAction extends ParentAction
{

    public function run(FindNotificationsByIdRequest $request)
    {
        return app(FindNotificationsByUserIdTask::class)->run($request->id);
    }
}
