<?php

namespace App\Libraries\Objects\Protocols;

class AuthHeader
{
    public ?string $Authorization;
    public ?string $userToken;

    /**
     * @return string|null
     */
    public function getAuthorization(): ?string
    {
        return $this->Authorization;
    }

    /**
     * @param string|null $Authorization
     */
    public function setAuthorization(?string $Authorization): void
    {
        $this->Authorization = $Authorization;
    }

    /**
     * @return string|null
     */
    public function getUserToken(): ?string
    {
        return str_replace("Bearer ", "", $this->Authorization);
    }

    /**
     * @param string|null $userToken
     */
    public function setUserToken(?string $userToken): void
    {
        $this->userToken = $userToken;
    }

    public function initBaseParam()
    {

    }
}