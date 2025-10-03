<?php

namespace App\Containers\AppSection\Tenantusers\Actions;

use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Tenantusers\Tasks\FindTenantusersByIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FindTenantusersByIdAction extends Action
{
    public function run(Request $request)
    {
        return app(FindTenantusersByIdTask::class)->run($request->id);
    }
}
