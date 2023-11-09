<?php

namespace App\Libraries\Objects\Protocols\User;

use App\Libraries\Objects\Protocols\BaseRequest;

class ModifyUserRequest extends BaseRequest
{
    public int $idx;
    public string $name;
    public string $phone;
    public string $role;
    public string $is_push_agree;

    /**
     * @return int
     */
    public function getIdx(): int
    {
        return $this->idx;
    }

    /**
     * @param int $idx
     */
    public function setIdx(int $idx): void
    {
        $this->idx = $idx;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getIsPushAgree(): string
    {
        return $this->is_push_agree;
    }

    /**
     * @param string $is_push_agree
     */
    public function setIsPushAgree(string $is_push_agree): void
    {
        $this->is_push_agree = $is_push_agree;
    }


    public function checkParam(): bool
    {
        $this->addNotNullList($this->getIdx());
        $this->addNotNullList($this->getName());
        $this->addNotNullList($this->getPhone());
        $this->addNotNullList($this->getRole());

        if (!$this->isNotNull()) {
            return false;
        }
        return true;
    }
}