<?php

/**
 * @apiGroup           Tenantusers
 * @apiName            createTenantusers
 *
 * @api                {POST} /v1/tenantusers Endpoint title here..
 * @apiDescription     Endpoint description here..
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  parameters here..
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  // Insert the response of the request here...
}
 */

use App\Containers\AppSection\Tenantusers\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('createtenantuserswithoutauth', [Controller::class, 'createTenantusers']);
