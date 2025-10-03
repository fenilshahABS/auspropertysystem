<?php

namespace App\Containers\AppSection\Propertytype\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jp_tenantusers")
 */
class Propertytype
{
    protected $type;
    protected $is_active;
    protected $search_val;
    protected $field_db;
    protected $per_page;

    public function __construct($request = null)
    {
        $this->type             = isset($request['type']) ? $request['type'] : null;

        $this->is_active          = isset($request['is_active']) ? $request['is_active'] : null;

        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->per_page = isset($request['per_page']) ? $request['per_page'] : null;
    }


    public function getType()
    {
        return $this->type;
    }

    public function getIsActive()
    {
        return $this->is_active;
    }

    public function getSearchVal()
    {
        return $this->search_val;
    }

    public function getFieldDB()
    {
        return $this->field_db;
    }

    public function getPerPage()
    {
        return $this->per_page;
    }
}
