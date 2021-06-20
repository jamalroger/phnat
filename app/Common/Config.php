<?php

namespace App\Common;

class Config
{

    public static function get($type, $key = null, $default = null)
    {
        $config =  require_once root . "/config/" . $type . ".php";
        if ($key) {
            return $config[$key];
        }
        return $config;
    }
}
