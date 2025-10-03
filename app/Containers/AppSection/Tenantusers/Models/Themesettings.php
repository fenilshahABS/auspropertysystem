<?php

namespace App\Containers\AppSection\Tenantusers\Models;

use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Models\UserModel;
use Illuminate\Notifications\Notifiable;
use App\Containers\AppSection\Role\Models\Role;

class Themesettings extends Model
{
  protected $table = 'pro_master_theme_settings';
  protected $fillable = [
    'name',
    'logo',
    'favicon',
    'description',
    'mobile',
    'email',
    'address',
    'mailer',
    'mailpath',
    'smtphost',
    'smtpemail',
    'smtppassword',
    'port',
    'ssl_tls_type',
    'google_play_store_link',
    'ios_play_store_link',
    'recaptcha_key',
    'recaptcha_secret',
    'facebook_link',
    'instagram_link',
    'youtube_link',
    'image_api_url',
    'sms_api_key'
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
  protected string $resourceKey = 'Eventtenantusers';
}
