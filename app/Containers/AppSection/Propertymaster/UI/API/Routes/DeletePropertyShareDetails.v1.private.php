<?php

/**
 * @apiGroup           Propertymaster
 * @apiName            DeletePropertymaster
 *
 * @api                {DELETE} /v1/propertymasters/:id Delete Propertymaster
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

use App\Containers\AppSection\Propertymaster\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('deletepropertysharedetails/{id}', [Controller::class, 'DeletePropertyShareDetails'])
    ->middleware(['auth:tenant']);
