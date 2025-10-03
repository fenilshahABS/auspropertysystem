<?php

namespace App\Containers\AppSection\Themesettings\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class ThemesettingsRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
