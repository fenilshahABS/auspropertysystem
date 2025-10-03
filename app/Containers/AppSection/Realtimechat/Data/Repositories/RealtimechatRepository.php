<?php

namespace App\Containers\AppSection\Realtimechat\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RealtimechatRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
