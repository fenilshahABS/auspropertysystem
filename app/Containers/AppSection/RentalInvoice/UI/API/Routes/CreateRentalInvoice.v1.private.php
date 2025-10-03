<?php

/**
 * @apiGroup           RentalInvoice
 * @apiName            CreateRentalInvoice
 *
 * @api                {POST} /v1/rental-invoices Create Rental Invoice
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

Route::post('rental-invoices', [Controller::class, 'createRentalInvoice'])
    ->middleware(['auth:api']);

