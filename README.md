# README #

##Example usage:##

```
#!php

<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
\Symfony\Component\Debug\ErrorHandler::register();
// APPLICATION
$app = new \AppServer\Application();
$app->get('/hello', function() use ($app) {
    return $app->json(['hello' => 'world']);
});

// SERVER
$debugging = true;
$server = new \AppServer\BasicServer($debugging);
$server->serve($app, 1337);
```