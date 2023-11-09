<?php
namespace App\Libraries\Error\Exception;

use App\Libraries\Error\ErrCode;
use App\Libraries\Logs\LogUtil;
use App\Libraries\Objects\Param;
use Exception;
use Throwable;

class CustomException extends Exception
{
    public function __construct($code, $message = null)
    {
        /**
         * Config\Exceptions 내부에 $ignoreCodes 에 200(SUCCESS)코드를 추가
         * 내부 오류코드 리턴을 위해 기본 코드값 200 세팅
         */
        parent::__construct('', 200);

        echo Param::result(ErrCode::setRetCode($code, $message));

    }
}