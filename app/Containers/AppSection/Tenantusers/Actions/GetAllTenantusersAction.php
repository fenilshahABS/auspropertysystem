<?php

namespace App\Containers\AppSection\Tenantusers\Actions;

use App\Containers\AppSection\Tenantusers\Tasks\GetAllTenantusersTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class GetAllTenantusersAction extends Action
{
    public function run(Request $request, $InputData)
    {
        return app(GetAllTenantusersTask::class)->run($InputData);
    }
}
