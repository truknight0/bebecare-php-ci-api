<?php

namespace App\Libraries\Objects\Protocols\User;

use App\Libraries\Objects\Protocols\BaseRequest;

class LoginRequest extends BaseRequest
{
    public string $name;
    public string $phone;
    public string $role;
    public ?int $is_push_agree = null;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string|null $role
     */
    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return int|null
     */
    public function getIsPushAgree(): ?int
    {
        return $this->is_push_agree;
    }

    /**
     * @param int|null $is_push_agree
     */
    public function setIsPushAgree(?int $is_push_agree): void
    {
        $this->is_push_agree = $is_push_agree;
    }


    public function checkParam(): bool
    {
        $this->addNotNullList($this->getName());
        $this->addNotNullList($this->getPhone());
        $this->addNotNullList($this->getRole());
        $this->addNotNullList($this->getIsPushAgree());

        if (!$this->isNotNull()) {
            return false;
        }
        return true;
    }
}