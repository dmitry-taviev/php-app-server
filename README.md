# README #
##Latest stable: v1.2##
##WTF?##
Fast, lightweight, easy-to-use application server written in pure php. Uses reactphp/http and eventloop(based on php generators or libevent).
##Why?##
* Bla bla bla **microservices** bla bla bla **cloud** bla bla bla **fault-tolerance** bla bla bla **reactive** bla bla bla **stateless**...
* This thing makes setting up & running any Silex backend api as easy as 2 lines of code.
* We get rid of dependencies such as nginx(or any other webserver) and php-fpm, thus easier setup & thinner docker images.
* More flexible since you add only what you really need.
* Performs better than similar phpfpm+webserver setup.
* We can troll nodejs users with this.
* Java had their application servers like Tomcat and Jetty since the beginning of time, so let's make php ecosystem as awesome!
##Bonus content includes:##
* Properly configured AppServer\Application that you can use instead of the default Silex one.
* AppServer\ApplicationComponent to help you in vertically partitioning your app(hope you know what that means). 
##TODO:##
* Fault-tolerance(like Hystrix)
* Healthchecks
* Sample Dockerfile
* json-api support
* ???
##Benchmarks:##
Performed on the [boilerplate app](https://bitbucket.org/apply/react-silex-example).

1000 threads sending 10 requests concurrently with a delay of 0.2s - just to give you an idea of its capabilities.
```
docker run --rm -t yokogawa/siege -c1000 -r10 -d0.2 http://myip:1337/persons/
** SIEGE 3.0.5
** Preparing 1000 concurrent users for battle.
The server is now under siege..      done.

Transactions:		       10000 hits
Availability:		      100.00 %
Elapsed time:		       10.16 secs
Data transferred:	        0.02 MB
Response time:		        0.41 secs
Transaction rate:	      984.25 trans/sec
Throughput:		        0.00 MB/sec
Concurrency:		      408.22
Successful transactions:       10000
Failed transactions:	           0
Longest transaction:	        7.44
Shortest transaction:	        0.00
```
During siege at it's peak it reached 97% of 1 CPU and kept memory usage at around 7MiB.

##Example usage:##
*  Inside your projects directory run the following command: 
```
composer require applyit/app-server:v1.*
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
