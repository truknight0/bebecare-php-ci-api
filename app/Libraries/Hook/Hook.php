<?php
namespace App\Libraries\Hook;

use App\Libraries\Error\Exception\CustomException;
use App\Libraries\Hook\Middleware\MiddleWareValue;
use App\Libraries\Objects\Param;
use App\Libraries\Utils\CiUtils;

class Hook
{
    /**
     * 1. Header Validation check
     * 2. Route check (login)
     * 3. Essential Params check (필수 파라미터 확인)
     * 4. Session Check
     * @throws CustomException
     */
    public static function sessionAuthorized()
    {

        /**
         * @var  $routes
         */
        foreach (MiddleWareValue::ROUTES as $url) {
            if (strpos(CiUtils::getUriString(), $url) !== false) {
                return true;
            }
        }

        /**
         * Header 체크
         */
//        $header = Param::requestHeader(HeaderRequest::class) ?? new HeaderRequest();

        return true;

    }
}

