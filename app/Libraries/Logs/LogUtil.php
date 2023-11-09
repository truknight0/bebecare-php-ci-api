<?php
/**
 * Created by PhpStorm.
 * User: johyunchol
 * Date: 2019-06-05
 * Time: 16:29
 */

namespace App\Libraries\Logs;

use App\Libraries\Error\ErrCode;
use App\Libraries\Objects\Param;
use App\Libraries\Utils\CiUtils;
use App\Libraries\Utils\TextUtils;
use App\Libraries\Utils\Utils;
use Config\Services;

class LogUtil
{
    /**
     * @var array
     */
    public static $logs = array();

    /**
     * @return array
     */
    public static function getLogs(): array
    {
        return self::$logs;
    }

    /**
     * @param array $logs
     */
    public static function setLogs(array $logs): void
    {
        self::$logs = $logs;
    }

    /**
     * @param LogItem $logItem
     */
    public static function addLogs(LogItem $logItem): void
    {
        array_push(self::$logs, $logItem);
    }

    public static function e($tag, $file, $function, $line, $message)
    {
        self::writeLog(Constants::ERROR, $tag, (array)new LogItem($file, $function, $line, $message));
    }

    public static function d($tag, $file, $function, $line, $message)
    {
        self::writeLog(Constants::DEBUG, $tag, (array)new LogItem($file, $function, $line, $message));
    }

    public static function i($tag, $file, $function, $line, $message)
    {
        self::writeLog(Constants::INFO, $tag, (array)new LogItem($file, $function, $line, $message));
    }

    public static function writeLog(string $type, $tag, $logItem)
    {
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $fileName = Constants::LOG_PATH . "/$year/$month/$day/$year-$month-$day";

        $path = Constants::LOG_PATH . "/$year/$month/$day";
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
            Utils::chownPath($path);
        }

        $base_url = Services::request()->config->baseURL;
        $api = CiUtils::getUriString();

        $file = fopen($fileName, "a+");

        Utils::chownPath($fileName);

        fwrite($file, sprintf("[%s][%5s][%s] >> [%5s][%s]\n", date("Y-m-d H:i:s", time()), $type, $base_url . $api, $tag, json_encode($logItem)));

        fclose($file);
    }

    public static function writeResult($result)
    {
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $basePath = Constants::LOG_PATH . "/$year/$month/$day/";

        $date = date("Y-m-d H:i:s", time());

        $ip_addr = $_SERVER['REMOTE_ADDR'];
        $agent = $_SERVER['HTTP_USER_AGENT'];

        $trace = debug_backtrace();

//        $obj = $trace[0]['object'];
        $base_url = Services::request()->config->baseURL;
        $api = Services::request()->uri->getPath();

        $request = json_decode(Param::$request, true);

        $response = $trace[1]['args'][0];

        switch ($result['code']) {
            case ErrCode::SUCCESS:
                $type = "INFO";
                break;
            default:
                $type = "ERROR";
                break;
        }

        $count = 0;
        if (!empty($request['userId'])) {
            $path = $basePath . "user/";
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
                Utils::chownPath($path);
            }

            $fileName = $path . $request['userId'];

            $file = fopen($fileName, "a+");
            Utils::chownPath($fileName);

            $str = sprintf("[%s][%s][%s][%s][%s][REQ] >> [%s]\n", $date, $type, $ip_addr, $agent, $base_url . $api, json_encode($request));
            if (self::$logs != NULL) {
                foreach (self::$logs as $log) {
                    $str .= sprintf("[%s][%s][%s][%s][%s][FUN] >> [%s]\n", $date, $type, $ip_addr, $agent, $base_url . $api, json_encode($log));
                }
            }

            $str .= sprintf("[%s][%s][%s][%s][%s][RES] >> [%s]\n", $date, $type, $ip_addr, $agent, $base_url . $api, json_encode($response));
            fwrite($file, $str);
            $count++;
        }

        if (!empty($request['driverId'])) {
            $path = $basePath . "driver/";
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
                Utils::chownPath($path);
            }

            $fileName = $path . $request['driverId'];

            $file = fopen($fileName, "a+");
            Utils::chownPath($fileName);
            $str = sprintf("[%s][%s][%s][%s][%s][REQ] >> [%s]\n", $date, $type, $ip_addr, $agent, $base_url . $api, json_encode($request));

            if (self::$logs != NULL) {
                foreach (self::$logs as $log) {
                    $str .= sprintf("[%s][%s][%s][%s][%s][FUN] >> [%s]\n", $date, $type, $ip_addr, $agent, $base_url . $api, json_encode($log));
                }
            }

            $str .= sprintf("[%s][%s][%s][%s][%s][RES] >> [%s]\n", $date, $type, $ip_addr, $agent, $base_url . $api, json_encode($response));

            fwrite($file, $str);
            $count++;
        }

        if (!empty($request['receiptNo'])) {
            $path = $basePath . "receiptNo/";
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
                Utils::chownPath($path);
            }

            $fileName = $path . $request['receiptNo'];


            $file = fopen($fileName, "a+");
            Utils::chownPath($fileName);

            $str = sprintf("[%s][%s][%s][%s][%s][REQ] >> [%s]\n", $date, $type, $ip_addr, $agent, $base_url . $api, json_encode($request));

            if (self::$logs != NULL) {
                foreach (self::$logs as $log) {
                    $str .= sprintf("[%s][%s][%s][%s][%s][FUN] >> [%s]\n", $date, $type, $ip_addr, $agent, $base_url . $api, json_encode($log));
                }
            }

            $str .= sprintf("[%s][%s][%s][%s][%s][RES] >> [%s]\n", $date, $type, $ip_addr, $agent, $base_url . $api, json_encode($response));

            fwrite($file, $str);
            $count++;
        }

        // 위의 로그 중에 하나도 찍히지 않은경우에...
        if ($count == 0) {
            $path = $basePath;
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
                Utils::chownPath($path);
            }

            $func = explode("/", $api);
            $func = $func[count($func) - 1];

            $fileName = $path . $func;

            $file = fopen($fileName, "a+");
            Utils::chownPath($fileName);
            $str = sprintf("[%s][%s][%s][%s][%s][REQ] >> [%s]\n", $date, $type, $ip_addr, $agent, $base_url . $api, json_encode($request));

            if (self::$logs != NULL) {
                foreach (self::$logs as $log) {
                    $str .= sprintf("[%s][%s][%s][%s][%s][FUN] >> [%s]\n", $date, $type, $ip_addr, $agent, $base_url . $api, json_encode($log));
                }
            }

            $str .= sprintf("[%s][%s][%s][%s][%s][RES] >> [%s]\n", $date, $type, $ip_addr, $agent, $base_url . $api, json_encode($response));

            fwrite($file, $str);
        }

    }

    public static function initLogItem($file, $function, $line, $param)
    {
        // query는 param에서 가져옴
        $query = $param['query'];

        // param 객체에서 query 삭제
        unset($param['query']);

        return new LogItem($file, $function, $line, $param, $query);
    }

}
