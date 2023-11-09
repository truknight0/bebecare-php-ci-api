<?php
/**
 * Created by PhpStorm.
 * User: johyunchol
 * Date: 2019-09-16
 * Time: 12:31
 */

namespace App\Libraries\Logs;

class LogItem
{
    public $time;
    public $file;
    public $function;
    public $line;
    public $param;
    public $query;

    /**
     * LogItem constructor.
     * @param $file
     * @param $function
     * @param $line
     * @param $param
     * @param $query
     * @param null $time
     */
    public function __construct($file, $function, $line, $param, $query = null)
    {
        $this->time = date("Y-m-d H:i:s.u", time());
        $this->file = $file;
        $this->function = $function;
        $this->line = $line;
        $this->param = $param;
        $this->query = $query;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time): void
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * @param mixed $function
     */
    public function setFunction($function): void
    {
        $this->function = $function;
    }

    /**
     * @return mixed
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param mixed $line
     */
    public function setLine($line): void
    {
        $this->line = $line;
    }

    /**
     * @return mixed
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @param mixed $param
     */
    public function setParam($param): void
    {
        $this->param = $param;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query): void
    {
        $this->query = $query;
    }


}
