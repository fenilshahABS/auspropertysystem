<?php

/**
 * @apiGroup           Tenantusers
 * @apiName            findTenantusersById
 *
 * @api                {GET} /v1/tenantusers/:id Endpoint title here..
 * @apiDescription     Endpoint description here..
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  parameters here..
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
 */

use App\Containers\AppSection\Tenantusers\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('getalltenantuserbysearch', [Controller::class, 'GetAllTenantuserBySearch'])
    ->middleware(['auth:tenant']);
