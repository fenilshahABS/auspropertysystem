<?php

namespace App\Containers\AppSection\Workermaster\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jp_tenantusers")
 */
class Workermaster
{
    protected $worker_name;
    protected $worker_mobile_no;
    protected $worker_email;
    protected $worker_address;
    protected $worker_city;
    protected $worker_state;
    protected $worker_country;
    protected $worker_zip_code;
    protected $is_active;
    protected $search_val;
    protected $field_db;
    protected $per_page;

    public function __construct($request = null)
    {
        $this->worker_name             = isset($request['worker_name']) ? $request['worker_name'] : null;
        $this->worker_mobile_no             = isset($request['worker_mobile_no']) ? $request['worker_mobile_no'] : null;
        $this->worker_email             = isset($request['worker_email']) ? $request['worker_email'] : null;
        $this->worker_address             = isset($request['worker_address']) ? $request['worker_address'] : null;
        $this->worker_city             = isset($request['worker_city']) ? $request['worker_city'] : null;
        $this->worker_state             = isset($request['worker_state']) ? $request['worker_state'] : null;
        $this->worker_country             = isset($request['worker_country']) ? $request['worker_country'] : null;
        $this->worker_zip_code             = isset($request['worker_zip_code']) ? $request['worker_zip_code'] : null;
        $this->is_active          = isset($request['is_active']) ? $request['is_active'] : null;
        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->per_page = isset($request['per_page']) ? $request['per_page'] : null;
    }


    public function getWorkerCountry()
    {
        return $this->worker_country;
    }
    public function getWorkerZipCode()
    {
        return $this->worker_zip_code;
    }
    public function getWorkerState()
    {
        return $this->worker_state;
    }
    public function getWorkerCity()
    {
        return $this->worker_city;
    }
    public function getWorkerAddress()
    {
        return $this->worker_address;
    }
    public function getWorkerName()
    {
        return $this->worker_name;
    }
    public function getWorkerMobileNo()
    {
        return $this->worker_mobile_no;
    }
    public function getWorkerEmail()
    {
        return $this->worker_email;
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
