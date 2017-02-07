<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 2/7/17
 * Time: 3:36 PM
 */

namespace AppServer\Encoder;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class EncoderServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['encoder.factory'] = function() {
            return new EncoderFactory();
        };
    }

}