<?php

namespace Deloz\Botium;

interface HandlerInterface
{
    public function init();
    public function start();
    public function index(Response $response);
    public function detail(Response $response);
    public function result(array $item = []);
}
