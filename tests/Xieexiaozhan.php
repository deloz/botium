<?php

namespace Tests;

use Symfony\Component\DomCrawler\Crawler;
use Deloz\Botium\Response;
use Deloz\Botium\Result;
use Deloz\Botium\Botium;

class Xieexiaozhan extends Botium
{
    public function start()
    {
        $res = $this->crawl('http://www.xieexiaozhan.com/xemh/list_1.html');
        if ($res) {
            $this->index($res);
        }
    }

    public function index(Response $res)
    {
        $res->doc('ul.piclist li a')->each(function (Crawler $node, $i) {
            $link = $node->attr('href');
            if ($link) {
                $res = $this->crawl($link);
                $res and $this->detail($res);
            }
        });
    }

    public function detail(Response $res)
    {
        $title = $res->doc('h1.mhtitle.yahei')->text();
        $images = [];
        $res->doc('ul.mnlt > li#imgshow > img')->each(function (Crawler $node, $i) use (&$images, $res) {
            $img = $node->attr('src');
            if ($img) {
                $images[] = $img;
            }
        });

        $this->result([
            'title' => $title,
            'images' => $images,
        ]);
    }

    public function result(array $item = [])
    {
        var_dump($item);
    }
}
