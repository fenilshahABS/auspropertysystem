<?php

/**
 * @apiGroup           RentalPropertyManagement
 * @apiName            DeleteRentalPropertyManagement
 *
 * @api                {DELETE} /v1/rental-property-managements/:id Delete Rental Property Management
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

use App\Containers\AppSection\RentalPropertyManagement\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('deletelatefeesdata/{id}', [Controller::class, 'deleteRentalPropertyManagement'])
    ->middleware(['auth:tenant']);
