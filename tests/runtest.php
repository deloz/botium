<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require __DIR__ . '/../vendor/autoload.php';

use Tests\Haixiu;
use Tests\Xieexiaozhan;
use Deloz\Botium\Botium;

$haixiu = new Haixiu([
    'baseUrl' => 'http://www.douban.com',
]);
$xieexiaozhan = new Xieexiaozhan([
    'baseUrl' => 'http://www.xieexiaozhan.com',
]);



Botium::register($haixiu);
Botium::register($xieexiaozhan);
