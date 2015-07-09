Botium
=====

A light web crawl written in PHP.

Installation
-----

1. Install composer:
	```bash
	curl -sS https://getcomposer.org/installer | php
	```

	You can add Botium as a dependency using the composer.phar CLI:

	```php
	php composer.phar require deloz/botium:~0.1
	```

2. Alternatively, you can specify Botium as dependency in your project's existing composer.json file:
	```json
	{
		"require": {
		  "deloz/botium": "~0.1"
		}
	}
	```

3. After installing, you need to require Composer's autoloader:
	```php
		require 'vendor/autoload.php';
	```

Running the tests
-----
```bash
cd tests
php runtest.php
```

Usage
-----

`$settings` must contain `baseUrl`, eg:
```php
$settings = [
	'baseUrl' => 'www.douban.com',
	'debug' => true,
	'interval' => 10,
	'every' => 5,
];
```

every site is a Class which inherit from `Deloz\Botium\Botium` with overriding the methods as blow:

```php
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
```

more examples, see directory [tests](https://github.com/deloz/botium/tests)

License
-----

licensed using the [MIT license](http://opensource.org/licenses/MIT)
