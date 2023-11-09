<?php

namespace App\Libraries\Objects\Models\Invite;

class InviteCodeInfo
{
    public $invite_code;
    public $user_idx;
    public $name;

    /**
     * @return mixed
     */
    public function getInviteCode()
    {
        return $this->invite_code;
    }

    /**
     * @param mixed $invite_code
     */
    public function setInviteCode($invite_code): void
    {
        $this->invite_code = $invite_code;
    }

    /**
     * @return mixed
     */
    public function getUserIdx()
    {
        return $this->user_idx;
    }

    /**
     * @param mixed $user_idx
     */
    public function setUserIdx($user_idx): void
    {
        $this->user_idx = $user_idx;
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

}