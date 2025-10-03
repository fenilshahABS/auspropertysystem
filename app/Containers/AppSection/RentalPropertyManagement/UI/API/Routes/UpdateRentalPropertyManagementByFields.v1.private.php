<?php

/**
 * @apiGroup           RentalPropertyManagement
 * @apiName            UpdateRentalPropertyManagement
 *
 * @api                {PATCH} /v1/rental-property-managements/:id Update Rental Property Management
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

Route::post('updaterentalpropertymanagementsbyfields/{id}', [Controller::class, 'UpdateRentalPropertyManagementByFields'])
    ->middleware(['auth:tenant']);
