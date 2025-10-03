<?php

namespace App\Containers\AppSection\Tenantusers\UI\API\Transformers;

use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Role\Models\Role;
use App\Containers\AppSection\Role\UI\API\Transformers\RoleTransformer;
use Apiato\Core\Traits\HashIdTrait;
use App\Ship\Parents\Transformers\Transformer;
use App\Containers\AppSection\Tenantusers\Models\Locations;
use League\Fractal\Resource\Collection;
use Carbon;

class TenantusersTransformer extends Transformer
{
  use HashIdTrait;

  protected array $availableIncludes = [];
  protected array $defaultIncludes = [
    'role',
  ];

  //: array
  public function transform(Tenantusers $tenantusers): array
  {

    $response = [
      'object' => $tenantusers->getResourceKey(),
      'id' => $tenantusers->getHashedKey(),
      'role_id'  => $this->encode($tenantusers->role_id),
      'first_name'  => $tenantusers->first_name,
      'last_name'  => $tenantusers->last_name,
      'profile_image'  => $tenantusers->profile_image,
      'dob'  => Carbon\Carbon::parse($tenantusers->dob)->format('d-m-Y'),
      'gender'  => $tenantusers->gender,
      'email'  => $tenantusers->user_email,
      'mobile'  => $tenantusers->mobile,
      'address'  => $tenantusers->address,
      'country'  => $tenantusers->country,
      'state'  => $tenantusers->state,
      'city'  => $tenantusers->city,
      'zipcode'  => $tenantusers->zipcode,
      'is_active'  => $tenantusers->is_active,
      'is_verify'  => $tenantusers->is_verify,
      'created_at' => $tenantusers->created_at,
      'updated_at' => $tenantusers->updated_at,
      'readable_created_at' => $tenantusers->created_at->diffForHumans(),
      'readable_updated_at' => $tenantusers->updated_at->diffForHumans(),

    ];

    return $response;
    /*
        return $response = $this->ifAdmin([
            'real_id'    => $tenantusers->id,
            // 'deleted_at' => $tenantusers->deleted_at,
        ], $response);
        */
  }

  //: Collection
  public function includeRole(Tenantusers $tenantusers)
  {
    //echo $tenantusers->role_id;die;
    //return $this->collection($tenantusers->role_id, new RoleTransformer(),'Role');
    //$redata[] = $tenantusers->role_id;
    return $this->collection($tenantusers->role, new RoleTransformer());
  }
}
