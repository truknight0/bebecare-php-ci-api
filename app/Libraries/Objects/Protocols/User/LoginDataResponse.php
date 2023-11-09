<?php

namespace App\Libraries\Objects\Protocols\User;

class LoginDataResponse
{
    public bool $is_first_user;
    public string $token;
    public ?array $children;

    /**
     * @return bool
     */
    public function isIsFirstUser(): bool
    {
        return $this->is_first_user;
    }

    /**
     * @param bool $is_first_user
     */
    public function setIsFirstUser(bool $is_first_user): void
    {
        $this->is_first_user = $is_first_user;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return array|null
     */
    public function getChildren(): ?array
    {
        return $this->children;
    }

    /**
     * @param array|null $children
     */
    public function setChildren(?array $children): void
    {
        $this->children = $children;
    }

}