<?php

namespace Deloz\Botium;

use BadFunctionCallException;

class Botium
{
    public $debug = false;
    public $requests;
    public $settings;

    public function __construct(array $settings = [])
    {
        $this->settings = $settings;

        isset($this->settings['debug']) and $this->debug = $this->settings['debug'];

        $this->requests[get_class($this)] = new Request($this->settings);
    }

    public function init()
    {
    }

    public function start()
    {
        Log::info('Method `start` is not override');
    }

    public function crawl($url)
    {
        return $this->requests[get_class($this)]->crawl($url);
    }

    public function index(Response $response)
    {
        Log::info('Method `index` is not override');

        $this->detail();
    }

    public function detail(Response $respones)
    {
        Log::info('Method `detail` is not override');

        $this->result();
    }

    public function config()
    {
        return $this->settings;
    }

    public static function register(Botium $handler)
    {
        $app = new App($handler);

        $config = $handler->config();
        $duration = 0;
        if ($config && isset($config['every']) && $config['every'] > 0) {
            $duration = $config['every'];
        }

        if ($duration > 0) {
            sleep($duration);
        }

        $app->run();
    }

    public function result(array $item = [])
    {
        Log::info('Method `result` is not override');
    }
}
