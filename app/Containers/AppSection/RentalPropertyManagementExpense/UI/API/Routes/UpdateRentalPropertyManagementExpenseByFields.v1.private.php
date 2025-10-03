<?php

/**
 * @apiGroup           RentalPropertyManagementExpense
 * @apiName            UpdateRentalPropertyManagementExpense
 *
 * @api                {PATCH} /v1/rental-property-management-expenses/:id Update Rental Property Management Expense
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

Route::post('updaterentalpropertymanagementexpensesbyfields/{id}', [Controller::class, 'UpdateRentalPropertyManagementExpenseByFields'])
    ->middleware(['auth:tenant']);
