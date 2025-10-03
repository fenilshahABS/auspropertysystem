<?php

/**
 * @apiGroup           Propertytype
 * @apiName            DeletePropertytype
 *
 * @api                {DELETE} /v1/propertytypes/:id Delete Propertytype
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

Route::get('deletepropertytypes/{id}', [Controller::class, 'deletePropertytype'])
    ->middleware(['auth:tenant']);
