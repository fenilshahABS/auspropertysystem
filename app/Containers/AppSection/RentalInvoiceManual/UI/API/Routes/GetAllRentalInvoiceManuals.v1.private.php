<?php

/**
 * @apiGroup           RentalInvoiceManual
 * @apiName            GetAllRentalInvoiceManuals
 *
 * @api                {GET} /v1/rental-invoice-manuals Get All Rental Invoice Manuals
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

use App\Containers\AppSection\RentalInvoiceManual\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('getrentalinvoicemanuals', [Controller::class, 'getAllRentalInvoiceManuals'])
    ->middleware(['auth:tenant']);
