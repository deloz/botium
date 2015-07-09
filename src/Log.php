<?php

namespace Deloz\Botium;

class Log
{
    public static function error($msg)
    {
        echo '[ERRO] ', $msg, PHP_EOL;
    }

    public static function info($msg)
    {
        echo '[INFO] ', $msg, PHP_EOL;
    }

    public static function success($msg)
    {
        echo '[SUCC] ', $msg, PHP_EOL;
    }
}
