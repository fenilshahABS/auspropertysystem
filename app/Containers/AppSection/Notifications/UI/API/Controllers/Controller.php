<?php

namespace App\Containers\AppSection\Notifications\UI\API\Controllers;

use App\Containers\AppSection\Notifications\Actions\FindNotificationsByUserIdAction;
use App\Containers\AppSection\Notifications\Actions\UpdateNotificationsAction;
use App\Containers\AppSection\Notifications\UI\API\Requests\FindNotificationsByIdRequest;
use App\Containers\AppSection\Notifications\UI\API\Requests\UpdateNotificationsRequest;
use App\Ship\Parents\Controllers\ApiController;


class Controller extends ApiController
{



    public function findNotificationsByUserId(FindNotificationsByIdRequest $request)
    {
        $notifications = app(FindNotificationsByUserIdAction::class)->run($request);
        return $notifications;
    }



    public function updateNotifications(UpdateNotificationsRequest $request)
    {
        $notifications = app(UpdateNotificationsAction::class)->run($request);
        return $notifications;
    }
}
