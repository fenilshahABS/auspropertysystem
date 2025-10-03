<?php

/**
 * @apiGroup           Dashboard
 * @apiName            UpdateDashboard
 *
 * @api                {PATCH} /v1/dashboards/:id Update Dashboard
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

use App\Containers\AppSection\Dashboard\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::patch('dashboards/{id}', [Controller::class, 'updateDashboard'])
    ->middleware(['auth:api']);

