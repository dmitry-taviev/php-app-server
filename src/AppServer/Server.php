<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 1/19/17
 * Time: 5:02 PM
 */

declare(strict_types=1);

namespace AppServer;


use Silex\Application;

interface Server
{

    const DEFAULT_HOST = '0.0.0.0';

    const DEFAULT_PORT = 80;

    public function serve(Application $application, int $port = self::DEFAULT_PORT, string $host = self::DEFAULT_HOST): void;

}