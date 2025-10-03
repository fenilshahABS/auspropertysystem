<?php

namespace App\Containers\AppSection\Tenantusers\Actions;

use App\Containers\AppSection\Tenantusers\Tasks\DeleteTenantusersTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DeleteTenantusersAction extends Action
{
    public function run(Request $request)
    {
        return app(DeleteTenantusersTask::class)->run($request->id);
    }
}
