<?php

/**
 * @apiGroup           Notifications
 * @apiName            FindNotificationsById
 *
 * @api                {GET} /v1/-notifications/:id Find  Notifications By Id
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'roles' => '']
 *
 * @apiHeader          {String} accept=application/json
 * @apiHeader          {String} authorization=Bearer
 *
 * @apiParam           {String} parameters here...
 *
 * @apiSuccessExample  {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *     // Insert the response of the request here...
 * }
 */

use App\Containers\AppSection\Notifications\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('findnotificationbyuserid/{id}', [Controller::class, 'FindNotificationsByUserId'])
    ->middleware(['auth:tenant']);
