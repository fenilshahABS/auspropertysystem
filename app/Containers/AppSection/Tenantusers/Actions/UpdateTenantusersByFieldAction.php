<?php

namespace App\Containers\AppSection\Tenantusers\Actions;

use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Tenantusers\Tasks\UpdateTenantusersByFieldTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
// use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon;

class UpdateTenantusersByFieldAction extends Action
{
  use HashIdTrait;
  public function run(Request $request, $InputData)
  {


    return app(UpdateTenantusersByFieldTask::class)->run($request->id, $InputData);
  }
}
