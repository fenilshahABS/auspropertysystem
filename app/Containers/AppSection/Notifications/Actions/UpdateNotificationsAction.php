<?php

namespace App\Containers\AppSection\Notifications\Actions;


use App\Containers\AppSection\Notifications\Tasks\UpdateNotificationsTask;
use App\Containers\AppSection\Notifications\UI\API\Requests\UpdateNotificationsRequest;

use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateNotificationsAction extends ParentAction
{

    public function run(UpdateNotificationsRequest $request)
    {

        return app(UpdateNotificationsTask::class)->run($request->id);
    }
}
