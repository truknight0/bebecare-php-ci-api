<?php


namespace App\Libraries\Objects\Protocols;


abstract class BaseRequest
{
    public array $notNullList = array();

    /**
     * @return array
     */
    public function getNotNullList(): ?array
    {
        return $this->notNullList;
    }

    /**
     * @param array|null $notNullList
     */
    public function setNotNullList(?array $notNullList): void
    {
        $this->notNullList = $notNullList;
    }

    public function addNotNullList($notNullItem): void
    {
        $this->notNullList[] = $notNullItem;
    }

    /**
     *
     */
    public function initBaseParam()
    {
//        array_push($this->notNullList, $this->getAppVer());
//        array_push($this->notNullList, $this->getAppOs());
    }

    /**
     * @return bool
     */
    abstract public function checkParam(): bool;

    /**
     * @return bool
     */
    public function isNotNull(): bool
    {
        foreach ($this->notNullList as $value) {
            if ($value !== 0 && $value == null) {
                return false;
            }
        }

        return true;
    }
}