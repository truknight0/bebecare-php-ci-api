<?php


namespace App\Libraries\Objects\Protocols;


use App\Libraries\Error\ErrCode;

class BaseResponse
{
    /**
     * @var int|null
     */
    public $code;
    /**
     * @var string|null
     */
    public $message;
    /**
     * @var
     */
    public $data;

    /**
     * BaseResponse constructor.
     * @param int|null $code
     */
    public function __construct($code = ErrCode::SUCCESS)
    {
        $this->code = $code;
        $this->message = ErrCode::StrRetCode($code);
    }

    /**
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * @param int|null $code
     */
    public function setCode(?int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

}


