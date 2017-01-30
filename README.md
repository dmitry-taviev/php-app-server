# README #

##Example usage:##
*  Inside your projects directory run the following command: 
```
composer require applyit/app-server v1.0.*
```
* Create a .php file in your projects directory with the following content:
```
#!php

<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
\Symfony\Component\Debug\ErrorHandler::register();
// APPLICATION
$app = new \AppServer\Application(); //or your existing Silex application
$app->get('/hello', function() use ($app) {
    return $app->json(['hello' => 'world']);
});

// SERVER
$debugging = true;
$server = new \AppServer\BasicServer($debugging);
$server->serve($app, 1337);
```
* Run the above .php file. If everything worked, you should try reaching /hello on your host or container's 1337 port
##Or just clone this: [boilerplate project](https://bitbucket.org/apply/react-silex-example)##