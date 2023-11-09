<?php


namespace App\Libraries\Utils;


class TextUtils
{
    public static function isEmpty(string $str, $array = null): bool
    {
        if ($array == null) {
            return (new TextUtils)->isEmptyString($str);
        }

        if (array_key_exists($str, $array)) {
            // 키가 배열안에 존재함
            $$str = $array[$str];
            return (new TextUtils)->isEmptyString($$str);
        } else {
            // 키가 배열안에 존재하지 않음
            return true;
        }
    }

    public static function isEmptyString(?string $str): bool
    {
        if (is_null($str) || strcmp($str, '') == 0) {
            return true;
        }

        return false;
    }

    public static function isShortMessage($message): bool
    {
        $length = self::getMessageLength($message);

        if ($length > 90) {
            return false;
        }

        return true;
    }

    public static function getMessageLength($message)
    {
        return mb_strwidth($message, 'UTF-8');
    }

    public static function decimalComma($value): string
    {
        return number_format($value);
    }

    const TYPE_OBJECT = 1;
    const TYPE_ARRAY = 2;

    public static function removeEmptyValue($param, $type): array
    {
        $ret = array();

        switch ($type) {
            case self::TYPE_OBJECT:
                $array = (array)$param;
                foreach ($array as $key => $val) {
                    if ($val !== NULL) {
                        $ret[$key] = $val;
                    }
                }
                break;

            case self::TYPE_ARRAY:
                foreach ($param as $key => $val) {
                    $array = (array)$val;
                    $temp = array();
                    foreach ($array as $key => $val) {
                        if ($val !== NULL) {
                            $temp[$key] = $val;
                        }
                    }
                    if (!empty($temp)) {
                        $ret[] = $temp;
                    }
                }
                break;
        }

        return $ret;
    }

    public static function arrayToText(array $array, string $glue = ''): string
    {
        return implode($glue, $array);
    }

    public static function stringToCharArray(string $string): ?array
    {
        $resultArr = array();

        $strLength = strlen($string);
        for ($i = 0; $i < $strLength; $i++) {
            $resultArr[$i] = $string[$i];
        }

        return $resultArr;
    }

    public static function isContains(?string $srcText, ?string $findString): ?bool
    {
        if ($srcText == null || $findString == null) {
            return false;
        }

        return (strpos($srcText, $findString) !== false);
    }

    public static function makeAuthNo(): string
    {
        return str_pad(mt_rand(0, 999), 3, 0, STR_PAD_LEFT) .
            str_pad(mt_rand(0, 999), 3, 0, STR_PAD_LEFT);
    }

    public static function toHourMin(?int $minute): string
    {
        if ($minute > 60) {
            $hour = $minute / 60;
            $min = $minute % 60;

            $time = sprintf("%d시간 %d분", $hour, $min);
        } else if ($minute == 60) {
            $time = "1시간";
        } else {
            $time = sprintf("%d분", $minute);
        }

        return $time;
    }

    public static function base64urlEncode($data)
    {
        // First of all you should encode $data to Base64 string
        $b64 = base64_encode($data);

        // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
        if ($b64 === false) {
            return false;
        }

        // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
        $url = strtr($b64, '+/', '-_');

        return $url;

        // Remove padding character from the end of line and return the Base64URL result
//        return rtrim($url, '=');
    }

    public static function snakeToCamelCase($str, $isFirstUpper = false)
    {
        $arr = explode('_', $str);
        foreach ($arr as $key => $value) {
            $cond = $key > 0 || $isFirstUpper;
            $arr[$key] = $cond ? ucfirst($value) : $value;
        }
        return implode('', $arr);
    }

    /**
     * converts the given kebap case input to camel case.
     *
     * @param string $str kebap case input
     *
     * @return string
     */
    public static function kebapToCamelCase(string $str, $isFirstUpper = false)
    {
        $arr = explode('-', $str);
        foreach ($arr as $key => $value) {
            $cond = $key > 0 || $isFirstUpper;
            $arr[$key] = $cond ? ucfirst($value) : $value;
        }
        return implode('', $arr);
    }

    public static function generateRandomString($characters, $length = 10)
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function generateRandomStringChar($length = 10): string
    {
        return self::generateRandomString('ABCDEFGHIJKLMNOPQRSTUVWXYZ', $length);
    }

    public static function generateRandomCharNumberString($length = 10)
    {
        return self::generateRandomString('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', $length);
    }

    public static function generateAllCaseRandomString($length = 10)
    {
        return self::generateRandomString('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', $length);
    }

}