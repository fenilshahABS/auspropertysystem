<?php

namespace App\Containers\AppSection\Tenantusers\Models;

use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Models\UserModel;
use Illuminate\Notifications\Notifiable;
use App\Containers\AppSection\Role\Models\Role;

class Tenantusers extends UserModel
{
  protected $table = 'pro_tenantusers';
  protected $fillable = [
    'id',
    'role_id',
    'first_name',
    'last_name',
    'profile_image',
    'dob',
    'gender',
    'email',
    'password',
    'user_has_key',
    'mobile',
    'address',
    'country',
    'state',
    'city',
    'zipcode',
    'is_active',
    'is_verify',
    'id_proof'
  ];

  protected $attributes = [];

  protected $hidden = [];

  protected $casts = [];

  protected $dates = [
    'created_at',
    'updated_at',
  ];

  /**
   * A resource key to be used in the serialized responses.
   */
  protected string $resourceKey = 'Tenantusers';

  public function role()
  {
    //return $this->hasMany(Role::class, 'role_id', 'id');
    return $this->hasMany(Role::class, 'id', 'role_id');
    //return $this->hasMany(Userroles::class, 'id', 'role_id');
  }
}
