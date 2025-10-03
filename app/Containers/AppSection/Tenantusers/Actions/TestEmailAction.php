<?php

namespace App\Containers\AppSection\Tenantusers\Actions;

use App\Containers\AppSection\Tenantusers\Tasks\TestEmailTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class TestEmailAction extends Action
{
    public function run(Request $request)
    {
        $getTenant= Auth::user();
        return app(TestEmailTask::class)->run($getTenant);
    }
}
