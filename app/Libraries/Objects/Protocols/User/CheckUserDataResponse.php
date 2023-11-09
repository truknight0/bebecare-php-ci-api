<?php

namespace App\Libraries\Objects\Protocols\User;

class CheckUserDataResponse
{
    public ?int $idx;
    public ?array $Children_list;

    /**
     * @return int|null
     */
    public function getIdx(): ?int
    {
        return $this->idx;
    }

    /**
     * @param int|null $idx
     */
    public function setIdx(?int $idx): void
    {
        $this->idx = $idx;
    }

    /**
     * @return array|null
     */
    public function getChildrenList(): ?array
    {
        return $this->Children_list;
    }

    /**
     * @param array|null $Children_list
     */
    public function setChildrenList(?array $Children_list): void
    {
        $this->Children_list = $Children_list;
    }


}