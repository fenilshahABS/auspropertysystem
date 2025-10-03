<?php

namespace App\Containers\AppSection\Realtimechat\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jp_tenantusers")
 */
class Realtimechat
{
    protected $id;
    protected $flag;
    protected $to_user_id;
    protected $type;
    protected $message;
    protected $image;
    protected $chatting_date_time;
    protected $status;
    protected $sender_type;
    protected $sent_user_id;
    protected $sent_user_name;
    protected $view_system_user_id;
    protected $view_system_user_name;

    public function __construct($data = [])
    {
        $this->flag = isset($data['flag']) ? $data['flag'] : null;
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->to_user_id = isset($data['to_user_id']) ? $data['to_user_id'] : null;
        $this->type = isset($data['type']) ? $data['type'] : null;
        $this->message = isset($data['message']) ? $data['message'] : null;
        $this->image = isset($data['image']) ? $data['image'] : null;
        $this->chatting_date_time = isset($data['chatting_date_time']) ? $data['chatting_date_time'] : null;
        $this->status = isset($data['status']) ? $data['status'] : null;
        $this->sender_type = isset($data['sender_type']) ? $data['sender_type'] : null;
        $this->sent_user_id = isset($data['sent_user_id']) ? $data['sent_user_id'] : null;
        $this->sent_user_name = isset($data['sent_user_name']) ? $data['sent_user_name'] : null;
        $this->view_system_user_id = isset($data['view_system_user_id']) ? $data['view_system_user_id'] : null;
        $this->view_system_user_name = isset($data['view_system_user_name']) ? $data['view_system_user_name'] : null;
    }
    public function getFlag()
    {
        return $this->flag;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getToUserId()
    {
        return $this->to_user_id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getChattingDateTime()
    {
        return $this->chatting_date_time;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getSenderType()
    {
        return $this->sender_type;
    }

    public function getSentUserId()
    {
        return $this->sent_user_id;
    }

    public function getSentUserName()
    {
        return $this->sent_user_name;
    }

    public function getViewSystemUserId()
    {
        return $this->view_system_user_id;
    }

    public function getViewSystemUserName()
    {
        return $this->view_system_user_name;
    }
}
