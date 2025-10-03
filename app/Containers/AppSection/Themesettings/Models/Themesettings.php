<?php

namespace App\Containers\AppSection\Themesettings\Models;

use App\Ship\Parents\Models\Model as ParentModel;

class Themesettings extends ParentModel
{
    protected $table = 'pro_master_theme_settings';
    protected $fillable = [
        'id',
        'name',
        'white_logo',
        'black_logo',
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
        'sms_api_key',
        'partner_client_commision',
        'partner_client_min_percentage',
        'currency',
        'tax',
        'rent_late_fees'
    ];

    protected $hidden = [];

    protected $casts = [];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Themesettings';
}
