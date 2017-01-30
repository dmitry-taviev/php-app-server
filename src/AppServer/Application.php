<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 1/30/17
 * Time: 4:12 PM
 */

namespace AppServer;


use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class Application extends \Silex\Application
{

    public function __construct(array $values = array())
    {
        parent::__construct($values);
        $this->register(new ServiceControllerServiceProvider());
        $this->register(new MonologServiceProvider(), [
            'monolog.use_error_handler' => true,
            'monolog.logfile' => 'php://stdout'
        ]);
        $this->before(function(Request $request) {
            if ($request->headers->get('Content-Type') === 'application/json') {
                $decoded = json_decode($request->getContent(), true);
                $request->request->replace(is_array($decoded) ? $decoded : []);
            }
        });
    }

}