<?php


namespace App\Libraries\Utils;


use App\Libraries\Common\DBMessage;
use App\Libraries\Error\ErrCode;
use App\Libraries\Error\Exception\CustomException;
use App\Libraries\Logs\LogUtil;
use Config\Database;

class Utils
{
    public static function chownPath($path)
    {
        if (!self::isLocalMode()) {
            chown($path, 'www-data');
            chgrp($path, 'www-data');
        }
    }

    public static function isEmailPattern($email)
    {
        return preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);
    }

    public static function getRoundMinute($second)
    {
        $min = $second / 60;
        $rest = $second % 60;

        $min = ($rest > 0) ? $min + 1 : $min;
        return $min;
    }

    public static function isJson(string $str)
    {
        json_decode($str);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * @return bool
     */
    public static function isDevelopment(): bool
    {
        switch (ENVIRONMENT) {
            case 'development':
            case 'testing':
                return true;
            case 'production':
                return false;
        }
    }

    public static function isDevMode()
    {
        /** hostname에 'bebecare'가 포함되어 있으면 리얼 서버라고 판단 */
        $host = "bebecare";

        if (strpos(exec("hostname"), $host) === false) {
            return true;
        }

        return false;
    }

    public static function isLocalMode()
    {
        $osNames = array();

        // 리얼로 판단할 주소를 적는 곳
        array_push($osNames, "Darwin");
        //array_push($host, "localhost:8081");

        foreach ($osNames as $os) {
            $osName = exec("uname");
            if (strcmp($osName, $os) == 0) {
                return true;
            }
        }

        return false;
    }

    // DB SQL result 클래스로 담기위한 함수
    public static function checkResult(string $query, int $type, string $classType = "object")
    {
        $db = Database::connect();

        $result = $db->query($query);

        if (!$result || $result->connID->errno != 0) {
            $error[] = $db->error();
            $error[] = $query;
            $error[] = $type;
            $error[] = $classType;
            LogUtil::addLogs(LogUtil::initLogItem(__CLASS__, __FUNCTION__, __LINE__, $error));
//            throw new CustomException(ErrCode::ERR_DB_FAIL);
            return null;
        }

        switch ($type) {
            case DBMessage::DB_SELECT:
                return $result->getResult($classType);
            case DBMessage::DB_SELECT_ROW:
                return $result->getUnbufferedRow($classType);
            case DBMessage::DB_COUNT:
                return $result->getFieldCount();
            case DBMessage::DB_INSERT:
            case DBMessage::DB_UPDATE:
            case DBMessage::DB_DELETE:
                return true;
            case DBMessage::DB_INSERT_ID:
                return $db->insertID();
            default:
                return false;
        }
    }

    /**
     * @param int $length
     * @return string
     */
    public static function generateAllCaseRandomString($length = 10): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getHourMinFromMin(int $min): string
    {
        $hourMin = "";
        $hours = floor($min / 60);
        $minutes = $min % 60;
        if ($hours > 0) {
            $hourMin = sprintf("%s시간", $hours);
        }
        if ($minutes > 0) {
            $hourMin = sprintf("%s %s분", $hourMin, $minutes);
        }

        return $hourMin;
    }

    public static function getHourMinFromSec(int $second): string
    {
        $hourMin = "";
        $hours = floor($second / 3600);
        $minutes = floor(($second % 3600) / 60);
        if ($hours > 0) {
            $hourMin = sprintf("%s시간", $hours);
        }
        if ($minutes > 0) {
            $hourMin = sprintf("%s %s분", $hourMin, $minutes);
        }

        return $hourMin;
    }

    public static function driverDrivingFormatter($isDriving): string
    {
        $format = "";
        switch ($isDriving) {
            case "1":
                $format = "운행";
                break;
            case "0":
            default:
                $format = "미운행";
                break;
        }
        return $format;
    }

    public static function driverStateFormatter($status): string
    {
        $format = "";
        switch ($status) {
            case "2":
                $format = "운행중";
                break;
            case "3":
                $format = "휴식";
                break;
            case "4":
                $format = "종료";
                break;
            case "5":
                $format = "불가능";
                break;
            case "1":
            default:
                $format = "대기";
                break;
        }
        return $format;
    }
}
