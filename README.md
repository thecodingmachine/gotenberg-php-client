<h3 align="center">Gotenberg PHP Client</h3>
<p align="center">A PHP client for the Gotenberg API</p>
<p align="center">
    <a href="https://travis-ci.org/thecodingmachine/gotenberg-php-client">
        <img src="https://travis-ci.org/thecodingmachine/gotenberg-php-client.svg?branch=master" alt="Travis CI">
    </a>
    <a href="https://scrutinizer-ci.com/g/thecodingmachine/gotenberg-php-client/?branch=master">
        <img src="https://scrutinizer-ci.com/g/thecodingmachine/gotenberg-php-client/badges/quality-score.png?b=master" alt="Scrutinizer">
    </a>
    <a href="https://codecov.io/gh/thecodingmachine/gotenberg-php-client/branch/master">
        <img src="https://codecov.io/gh/thecodingmachine/gotenberg-php-client/branch/master/graph/badge.svg" alt="Codecov">
    </a>
</p>

---

[Gotenberg](https://github.com/thecodingmachine/gotenberg) is a stateless API for converting Markdown files, HTML files and Office documents to PDF.
This package helps you to interact with this API using PHP.

# Menu

* [Install](#install)
* [Docker](#docker)
* [Usage](#usage)

## Install

```bash
$ composer require thecodingmachine/gotenberg-php-client
```

We also suggest installing `composer require php-http/guzzle6-adapter`, unless your project already have a PSR7 `HttpClient`!

## Docker

As the [Gotenberg](https://github.com/thecodingmachine/gotenberg) API is provided within a Docker image, you'll have to add it
to your Docker Compose stack:

```yaml
version: '3'

services:

  # your others services

  gotenberg:
    image: thecodingmachine/gotenberg:1.0.0
```

You may now start your stack using:

```bash
$ docker-compose up --scale gotenberg=your_number_of_instances
```

When requesting the Gotenberg service with your client, Docker will automatically redirect a request to a Gotenberg container
according to the round-robin strategy.

## Usage

```php
<?php

namespace YourAwesomeNamespace;

use TheCodingMachine\Gotenberg\Client;
use TheCodingMachine\Gotenberg\ClientException;
use TheCodingMachine\Gotenberg\Document;

use GuzzleHttp\Psr7\LazyOpenStream;

class YourAwesomeClass {
    
    public function yourAwesomeMethod()
    {
        $client = new Client('gotenberg:3000', new \Http\Adapter\Guzzle6\Client());
        # or the following if you want the client to discover automatically an installed implementation of the PSR7 `HttpClient`.
        $client = new Client('gotenberg:3000');
        
        # let's instantiate some documents you wish to convert.
        $yourOfficeDocument = new Document('file.docx');
        $yourOfficeDocument->feedFromPath('path/to/file');
        
        $yourHTMLDocument = new Document('file.html');
        $yourHTMLDocument->feedFromStream(new LazyOpenStream('path/to/file', 'r'));
        
        # now let's send those documents!
        try {
            # store method allows you to... store the resulting PDF in a particular folder.
            $client->store([
                $yourOfficeDocument,
                $yourHTMLDocument
            ], 'path/to/folder/you/want/the/pdf/to/be/store');
            
            # if you wish to redirect the response directly to the browser, you may also use:
            $response = $client->forward([
                            $yourOfficeDocument,
                            $yourHTMLDocument
                        ]);
            
        } catch (ClientException $e) {
            # this exception is thrown by the client if the API has returned a code != 200.
        } catch (\Http\Client\Exception $e) {
            # some PSR7 exception.
        } catch (\Exception $e) {
            # some (random?) exception.
        }
    }
    
}
```

Voilà! :smiley:

---

Would you like to update this documentation ? Feel free to open an [issue](../../issues).