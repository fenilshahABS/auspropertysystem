<?php

namespace App\Containers\AppSection\TaskManagement\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jp_tenantusers")
 */
class TaskManagement
{
    protected $task_name;
    protected $task_management_id;
    protected $user_id;
    protected $task_details;
    protected $task_inspection_date;
    protected $custum_task_notification;
    protected $task_inspection_time;
    protected $task_datetime;
    protected $status;
    protected $id;
    protected $custom_email;

    protected $search_val;
    protected $field_db;
    protected $per_page;

    public function __construct($request = null)
    {
        $this->task_management_id             = isset($request['task_management_id']) ? $request['task_management_id'] : null;
        $this->id             = isset($request['id']) ? $request['id'] : null;
        $this->custum_task_notification             = isset($request['custum_task_notification']) ? $request['custum_task_notification'] : null;
        $this->user_id             = isset($request['user_id']) ? $request['user_id'] : null;
        $this->task_name             = isset($request['task_name']) ? $request['task_name'] : null;
        $this->task_details          = isset($request['task_details']) ? $request['task_details'] : null;
        $this->task_inspection_date             = isset($request['task_inspection_date']) ? $request['task_inspection_date'] : null;
        $this->task_inspection_time          = isset($request['task_inspection_time']) ? $request['task_inspection_time'] : null;
        $this->task_datetime          = isset($request['task_datetime']) ? $request['task_datetime'] : null;
        $this->status             = isset($request['status']) ? $request['status'] : null;
        $this->custom_email             = isset($request['custom_email']) ? $request['custom_email'] : null;


        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->per_page = isset($request['per_page']) ? $request['per_page'] : null;
    }

    public function getCustomEmail()
    {
        return $this->custom_email;
    }
    public function getTaskManagementId()
    {
        return $this->task_management_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCustomTaskNotification()
    {
        return $this->custum_task_notification;
    }
    public function getStatus()
    {
        return $this->status;
    }

    public function getTaskDateTime()
    {
        return $this->task_datetime;
    }
    public function getUserId()
    {
        return $this->user_id;
    }

    public function getTaskName()
    {
        return $this->task_name;
    }

    public function getTaskDetails()
    {
        return $this->task_details;
    }

    public function getTaskInspectionDate()
    {
        return $this->task_inspection_date;
    }

    public function getTaskInspectionTime()
    {
        return $this->task_inspection_time;
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
