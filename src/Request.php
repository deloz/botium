<?php

namespace Deloz\Botium;

use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class Request
{
    public $baseUrl;
    public $interval;
    public $referer;
    public $url;
    public $headers = [];
    public $settings = [];
    public $promises = [];

    public function __construct(array $settings = [])
    {
        if (!isset($settings['baseUrl'])) {
            throw new InvalidArgumentException('settings config need baseUrl');
        }

        $this->settings = $settings;
        $this->interval = intval(isset($this->settings['interval']) ?  $this->settings['interval'] : 0);
        $this->headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:41.0) Gecko/20100101 Firefox/41.0',
            'Accept-Language' => 'zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        ];

        $jar = new CookieJar;
        $this->client = new Client([
            'base_uri' => $settings['baseUrl'],
            'headers' => $this->headers,
            'timeout' => isset($this->settings['timeout']) ? $this->settings['timeout'] : 60,
            'cookies' => $jar,
            'proxy' => isset($this->settings['proxy']) ? $this->settings['proxy'] : [],
            'debug' => isset($this->settings['debug']) ? $this->settings['debug'] : false,
        ]);
    }

    public function crawl($url)
    {
        $this->url = $url;

        Log::info('Start to fetch : ' . $this->url);

        if ($this->referer) {
            $this->addHeader('Referer', $this->referer);
        } else {
            $this->referer = $url;
        }

        try {
            $startTime = microtime(true);
            $res = $this->client->get($this->url, [
                'headers' => $this->headers,
            ]);
            $useTime = microtime(true) - $startTime;
            if ($res->getStatusCode() == 200) {
                Log::success('Crawl Success.');
                $resp =  new Response($res, $this->url);
            } else {
                Log::error('Crawl Got Status ' . $res->getStatusCode());
                $resp = false;
            }
            Log::info('use time: ' . $useTime . ' seconds.');
        } catch (RequestException $e) {
            Log::error('request error: ' . $e->getMessage());
            $resp = false;
        }


        if ($this->interval > 0) {
            sleep($this->interval);
        }

        return $resp;
    }

    public function addHeader($name, $val)
    {
        $this->headers[$name] = $val;
    }
}
