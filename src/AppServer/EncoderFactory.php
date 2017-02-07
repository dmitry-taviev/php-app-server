<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 2/7/17
 * Time: 2:28 PM
 */

declare(strict_types=1);

namespace AppServer;


use Neomerx\JsonApi\Contracts\Schema\ContainerInterface;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use Neomerx\JsonApi\Factories\Factory;

class EncoderFactory extends Factory
{

    public function createEncoder(ContainerInterface $container, EncoderOptions $encoderOptions = null)
    {
        $encoder = new Encoder($this, $container, $encoderOptions);
        $encoder->setLogger($this->logger);
        return $encoder;
    }

}