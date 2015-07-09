<?php
namespace Deloz\Botium;

class Encoding
{
    public static function detectEncoding($str)
    {
        return mb_detect_encoding($str, ['UTF-8', 'CP936', 'ASCII']);
    }

    public static function convertEncoding($str, $toEncoding)
    {
        return mb_convert_encoding($str, $toEncoding, self::detectEncoding($str));
    }

    public static function convertToUtf8($str)
    {
        return self::convertEncoding($str, 'UTF-8');
    }
}
