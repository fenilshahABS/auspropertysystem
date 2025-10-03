<?php

namespace App\Ship\Parents\Repositories;

use Apiato\Core\Abstracts\Repositories\Repository as AbstractRepository;
use App\Ship\Parents\Absoluteweb\AbsolutewebRepository;

//abstract class Repository extends AbstractRepository
abstract class Repository extends AbsolutewebRepository
{
  /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        parent::boot();
    }
}
