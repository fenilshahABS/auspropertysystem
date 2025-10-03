<?php

namespace App\Containers\AppSection\Tenantusers\Actions;

use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Tenant\Models\Tenant;
use App\Containers\AppSection\Tenantusers\Tasks\UpdateTenantusersPasswordTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;
use Intervention\Image\ImageManager;
use Carbon;


class UpdateTenantusersPasswordAction extends Action
{
  use HashIdTrait;
  public function run(Request $request, $InputData)
  {
    $getTenant = Auth::user();
    $tenantid = $getTenant['tenant_id'];
    //$password = $InputData->getOldPassword();
    $user_id = $this->decode($InputData->getUserID());
    $newpassword = $InputData->getNewPassword();
    $newrepassword = $InputData->getNewRePassword();

    $tenant_user_Data = Tenantusers::where('id', $user_id)->first();

    //if($password == $tenant_user_Data->user_has_key){
    if ($newpassword == $newrepassword) {
      $data = $request->sanitizeInput([
        // add your request data here
        'password' => Hash::make($newpassword),
        'user_has_key' => $newpassword,
      ]);
      $returnData = app(UpdateTenantusersPasswordTask::class)->run($user_id, $data, $getTenant);
    } else {
      $returnData['message'] = "Password not match";
    }
    //}else{
    //  $returnData['message']="Password not match";
    //}

    return $returnData;
  }
}
