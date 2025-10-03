<?php

/**
 * @apiGroup           Propertytype
 * @apiName            UpdatePropertytype
 *
 * @api                {PATCH} /v1/propertytypes/:id Update Propertytype
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

use App\Containers\AppSection\Propertytype\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('propertytypesbyfields/{id}', [Controller::class, 'updatePropertytypeByFields'])
    ->middleware(['auth:tenant']);
