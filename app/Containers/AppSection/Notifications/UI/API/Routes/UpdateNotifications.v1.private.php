<?php

/**
 * @apiGroup           Notifications
 * @apiName            UpdateNotifications
 *
 * @api                {PATCH} /v1/-notifications/:id Update  Notifications
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

Route::get('updatenotificationstatus/{id}', [Controller::class, 'updateNotifications'])
    ->middleware(['auth:tenant']);
