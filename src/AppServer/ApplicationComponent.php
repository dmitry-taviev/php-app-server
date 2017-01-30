<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 1/30/17
 * Time: 5:16 PM
 */

namespace AppServer;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

abstract class ApplicationComponent implements ServiceProviderInterface, ControllerProviderInterface
{

    public function register(Container $pimple): void
    {
        $this->registerServices($pimple);
    }

    public function connect(Application $app): ControllerCollection
    {
        $app->register($this);
        return $this->registerRoutes($app['controllers_factory'], $app);
    }

    abstract protected function registerServices(Container $container): void;

    abstract protected function registerRoutes(ControllerCollection $routing, Application $application): ControllerCollection;

}