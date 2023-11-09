<?php

namespace App\Libraries\Objects\Models\User;

class UserInfo
{
    public $idx;
    public $name;
    public $phone;
    public $role;
    public $is_push_agree;
    public $user_type;
    public $token;
    public $created_at;

    /**
     * @return mixed
     */
    public function getIdx()
    {
        return $this->idx;
    }

    /**
     * @param mixed $idx
     */
    public function setIdx($idx): void
    {
        $this->idx = $idx;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getIsPushAgree()
    {
        return $this->is_push_agree;
    }

    /**
     * @param mixed $is_push_agree
     */
    public function setIsPushAgree($is_push_agree): void
    {
        $this->is_push_agree = $is_push_agree;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @param mixed $user_type
     */
    public function setUserType($user_type): void
    {
        $this->user_type = $user_type;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }


}