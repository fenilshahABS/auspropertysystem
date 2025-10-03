<?php

/**
 * @apiGroup           Workermaster
 * @apiName            Workermaster
 *
 * @api                {PATCH} /v1/Workermaster/:id Update Workermaster
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

use App\Containers\AppSection\Workermaster\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('workermasterbyfields/{id}', [Controller::class, 'updateWorkermasterByFields'])
    ->middleware(['auth:tenant']);
