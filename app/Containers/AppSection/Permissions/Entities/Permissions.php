<?php

namespace App\Containers\AppSection\Permissions\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jp_tenantusers")
 */
class Permissions
{
    protected $type;
    protected $id_decode;
    protected $status;
    protected $role_id;
    protected $permission_id;
    protected $search_val;
    protected $field_db;
    protected $per_page;

    public function __construct($request = null)
    {
        $this->id_decode             = isset($request['id_decode']) ? $request['id_decode'] : null;
        $this->type             = isset($request['type']) ? $request['type'] : null;
        $this->role_id             = isset($request['role_id']) ? $request['role_id'] : null;
        $this->permission_id             = isset($request['permission_id']) ? $request['permission_id'] : null;
        $this->status          = isset($request['status']) ? $request['status'] : null;
        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->per_page = isset($request['per_page']) ? $request['per_page'] : null;
    }

    public function getId()
    {
        return $this->id_decode;
    }
    public function getRoleId()
    {
        return $this->role_id;
    }

    public function getPermissionId()
    {
        return $this->permission_id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getStatus()
    {
        return $this->status;
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
