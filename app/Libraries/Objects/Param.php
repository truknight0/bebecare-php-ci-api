<?php

namespace App\Libraries\Objects;

use App\Libraries\Common\Gson;
use App\Libraries\Error\ErrCode;
use App\Libraries\Error\Exception\CustomException;
use App\Libraries\Logs\LogUtil;
use App\Libraries\Utils\TextUtils;
use Config\Services;
use Exception;


class Param
{
    const POST = "post";
    const GET = "get";

    public static $header;
    public static $request;

    protected $class;

    /**
     * @param string $classType
     * @return mixed
     * @throws CustomException
     */
    public static function requestHeader(string $classType)
    {
        try {
            $header = Services::request()->headers();
        } catch (Exception $e) {
            throw new CustomException(ErrCode::ERR_MSG_INVALID_HEADER);
        }

        $object = self::parserHeader($classType, $header);
        if ($object == null) {
            throw new CustomException(ErrCode::ERR_MSG_INVALID_HEADER);
        }

        $object->initBaseParam();

        return $object;
    }

    /**
     * @param string $classType
     * @return array|mixed|null
     * @throws CustomException
     */
    public static function requestBody(string $classType)
    {
        try {
            $body = Services::request()->getBody();
        } catch (Exception $e) {
            throw new CustomException(ErrCode::ERR_MSG_INVALID_PARAMETER);
        }

        if ($body == null) {
            throw new CustomException(ErrCode::ERR_MSG_INVALID_PARAMETER);
        }

        LogUtil::i("REQUEST_BODY", __CLASS__, __FUNCTION__, __LINE__, $body);

        try {
            $request = Gson::fromJson($classType, $body);
        } catch (Exception $e) {
            throw new CustomException(ErrCode::ERR_MSG_INVALID_PARAMETER);
        }

        if ($request == null) {
            throw new CustomException(ErrCode::ERR_MSG_INVALID_PARAMETER);
        }

        $request->initBaseParam();
        if (!$request->checkParam()) {
            throw new CustomException(ErrCode::ERR_MSG_INVALID_PARAMETER);
        }

        return $request;
    }

    /**
     * @param object|array $result
     * @return false|string
     */
    public static function result($result)
    {
        // 값이 NULL인 경우에 response에 담지 않기 위해 제거 하는 로직
        $ret = TextUtils::removeEmptyValue($result, TextUtils::TYPE_OBJECT);

        // request data 로그 추가
        LogUtil::writeResult($ret);

        return json_encode($result);
    }

    public static function parserHeader(string $classType, array $array)
    {
        $object = new $classType();

        foreach ($array as $key => $obj) {
            $key = TextUtils::kebapToCamelCase($key, true);
            $setterName = 'set' . $key;

            if (method_exists($object, $setterName)) {
                $object->$setterName($obj->getValue());
            }
        }

        return $object;
    }
}
