<?php

namespace Deloz\Botium;

class App
{
    public $handler;

    public function __construct(Botium $handler)
    {
        $this->handler = $handler;
    }

    public function run()
    {
        $this->handler->init();
        $this->handler->start();
    }
}
