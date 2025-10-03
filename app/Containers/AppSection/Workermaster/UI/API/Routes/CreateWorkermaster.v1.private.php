<?php

/**
 * @apiGroup           Workermaster
 * @apiName            CreateWorkermaster
 *
 * @api                {POST} /v1/workermaster Create Workermaster
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

Route::post('createworkermaster', [Controller::class, 'createWorkermaster'])
    ->middleware(['auth:tenant']);
