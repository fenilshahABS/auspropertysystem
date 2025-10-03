<?php

/**
 * @apiGroup           RentalPropertyManagementExpense
 * @apiName            DeleteRentalPropertyManagementExpense
 *
 * @api                {DELETE} /v1/rental-property-management-expenses/:id Delete Rental Property Management Expense
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

use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('deleterentalpropertymanagementworkerdetails', [Controller::class, 'DeleteRentalPropertyManagementWorkerDetails'])
    ->middleware(['auth:tenant']);
