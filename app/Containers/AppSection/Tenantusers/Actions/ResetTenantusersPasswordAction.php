<?php

namespace App\Containers\AppSection\Tenantusers\Actions;

use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Tenantusers\Tasks\ResetTenantusersPasswordTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Tenantusers\UI\API\Requests\CreateTenantusersRequest;
use Intervention\Image\ImageManager;
use Carbon;


class ResetTenantusersPasswordAction extends Action
{
  public function run(CreateTenantusersRequest $request, $InputData)
  {
    return app(ResetTenantusersPasswordTask::class)->run($InputData);
  }
}
