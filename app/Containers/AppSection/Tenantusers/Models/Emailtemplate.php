<?php

namespace App\Containers\AppSection\Tenantusers\Models;

use App\Ship\Parents\Models\Model;

class Emailtemplate extends Model
{
  protected $table = 'pro_emailtemplate';
  protected $fillable = [
    'id',
    'task',
    'subject',
    'message',
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
  protected string $resourceKey = 'Emailtemplate';
}
