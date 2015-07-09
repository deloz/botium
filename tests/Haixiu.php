<?php

namespace Tests;

use Symfony\Component\DomCrawler\Crawler;
use Deloz\Botium\Response;
use Deloz\Botium\Botium;

class Haixiu extends Botium
{
    public function start()
    {
        $res = $this->crawl('http://www.douban.com/group/haixiuzu/discussion');
        $res and $this->index($res);
    }

    public function index(Response $res)
    {
        $res->doc('td.title > a')->each(function (Crawler $node, $i) {
            $link = $node->attr('href');
            if ($link) {
                $res = $this->crawl($link);
                $res and $this->detail($res);
            }
        });
    }

    public function detail(Response $res)
    {
        $title = $res->doc('#content > h1')->text();
        $author = $res->doc('#content > div > div.article > div.topic-content.clearfix > div.topic-doc > h3 > span.from > a')->text();
        $images = [];
        $res->doc('div.topic-content > div.topic-figure.cc img')->each(function (Crawler $node, $i) use (&$images, $res) {
            $img = $node->attr('src');
            if ($img) {
                $images[] = $img;
            }
        });

        $this->result([
            'title' => $title,
            'author' => $author,
            'images' => $images,
        ]);
    }

    public function result(array $item = [])
    {
        var_dump($item);
    }
}
