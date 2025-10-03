<?php

/**
 * @apiGroup           Propertyreports
 * @apiName            UpdatePropertyreports
 *
 * @api                {PATCH} /v1/propertyreports/:id Update Propertyreports
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

use App\Containers\AppSection\Propertyreports\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::patch('propertyreports/{id}', [Controller::class, 'updatePropertyreports'])
    ->middleware(['auth:api']);

