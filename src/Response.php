<?php

namespace Deloz\Botium;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

class Response
{
    public $url;
    public $rawDocument;
    public $document;

    public function __construct(ResponseInterface $res, $url)
    {
        $this->url = $url;

        $body = Encoding::convertToUtf8($res->getBody());

        $this->rawDocument = $body;

        $crawler = new Crawler;
        $crawler->addContent($body);

        $this->document = $crawler;
    }

    public function doc($cssPath)
    {
        return $this->document->filter($cssPath);
    }

    public function content()
    {
        return $this->rawDocument;
    }
}
