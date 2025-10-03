<?php

/**
 * @apiGroup           RentalInvoice
 * @apiName            GetAllRentalInvoices
 *
 * @api                {GET} /v1/rental-invoices Get All Rental Invoices
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

use App\Containers\AppSection\RentalInvoice\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('getrentalinvoicesbypagination', [Controller::class, 'GetAllRentalInvoicesPagination'])
    ->middleware(['auth:tenant']);
