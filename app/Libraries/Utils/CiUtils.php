<?php


namespace App\Libraries\Utils;


use CodeIgniter\Config\Services;

class CiUtils
{
    public static function getUriString() {
        return Services::request()->uri->getPath();
    }
}