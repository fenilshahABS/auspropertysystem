<?php

/**
 * @apiGroup           Expensemanagement
 * @apiName            UpdateExpensemanagement
 *
 * @api                {PATCH} /v1/expensemanagements/:id Update Expensemanagement
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

use App\Containers\AppSection\Expensemanagement\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('updatexxpensemanagementbyfields/{id}', [Controller::class, 'updateExpensemanagementByFields'])
    ->middleware(['auth:tenant']);
