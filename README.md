# Gotenberg PHP client

A simple PHP client for interacting with a Gotenberg API.

## Install

Unless your project already have a PSR7 `HttpClient`, install `php-http/guzzle6-adapter`:

```bash
$ composer require php-http/guzzle6-adapter
```

Then the PHP client:

```bash
$ composer require thecodingmachine/gotenberg-php-client
```

## Usage

```php
use TheCodingMachine\Gotenberg\Client;
use TheCodingMachine\Gotenberg\ClientException;
use TheCodingMachine\Gotenberg\DocumentFactory;
use TheCodingMachine\Gotenberg\HTMLRequest;
use TheCodingMachine\Gotenberg\Request;
use TheCodingMachine\Gotenberg\RequestException;
use GuzzleHttp\Psr7\LazyOpenStream;

# create the client.
$client = new Client('http://localhost:3000', new \Http\Adapter\Guzzle6\Client());
# ... or the following if you want the client to discover automatically an installed implementation of the PSR7 `HttpClient`.
$client = new Client('http://localhost:3000');

# prepare the files required for your conversion.

# from a path.
$index = DocumentFactory::makeFromPath('index.html', '/path/to/file');
# ... or from your own stream.
$stream = new LazyOpenStream('/path/to/file', 'r');
$index = DocumentFactory::makeFromStream('index.html', $stream);
// ... or from a string.
$index = DocumentFactory::makeFromString('index.html', '<html>Foo</html>');

$header = DocumentFactory::makeFromPath('header.html', '/path/to/file');
$footer = DocumentFactory::makeFromPath('footer.html', '/path/to/file');
$assets = [
    DocumentFactory::makeFromPath('style.css', '/path/to/file'),
    DocumentFactory::makeFromPath('img.png', '/path/to/file'),
];

try {
    $request = new HTMLRequest($index);
    $request->setHeader($header);
    $request->setFooter($footer);
    $request->setAssets($assets);
    $request->setPaperSize(Request::A4);
    $request->setMargins(Request::NO_MARGINS);
    $request->setScale(0.75);
    
    # store method allows you to... store the resulting PDF in a particular destination.
    $client->store($request, 'path/you/want/the/pdf/to/be/stored.pdf');
    
    # if you wish to redirect the response directly to the browser, you may also use:
    $client->post($request);          
} catch (RequestException $e) {
    # this exception is thrown if given paper size or margins are not correct.
} catch (ClientException $e) {
    # this exception is thrown by the client if the API has returned a code != 200.
}
```

For more complete usages, head to the [documentation](https://thecodingmachine.github.io/gotenberg).

## Badges

[![Travis CI](https://travis-ci.org/thecodingmachine/gotenberg-php-client.svg?branch=master)](https://travis-ci.org/thecodingmachine/gotenberg-php-client)
[![Scrutinizer](https://scrutinizer-ci.com/g/thecodingmachine/gotenberg-php-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/thecodingmachine/gotenberg-php-client/?branch=master)
