<?php

/**
 * @apiGroup           RentalInvoiceManual
 * @apiName            FindRentalInvoiceManualById
 *
 * @api                {GET} /v1/rental-invoice-manuals/:id Find Rental Invoice Manual By Id
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

use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('findrentalinvoicemanualsproperty/{id}', [Controller::class, 'findRentalInvoiceManualByIdProperty'])
    ->middleware(['auth:tenant']);
