<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 2/7/17
 * Time: 2:28 PM
 */

declare(strict_types=1);

namespace AppServer\Encoder;


use Neomerx\JsonApi\Contracts\Schema\ContainerInterface;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use Neomerx\JsonApi\Factories\Factory;
use Neomerx\JsonApi\Schema\Container;

class EncoderFactory extends Factory
{

    /**
     * @var EncoderOptions
     */
    protected $encoderOptions;

    public function __construct()
    {
        parent::__construct();
        $this->encoderOptions = new EncoderOptions(
            JSON_UNESCAPED_UNICODE |
            JSON_PRESERVE_ZERO_FRACTION
        );
    }

    public function createEncoder(ContainerInterface $container, EncoderOptions $encoderOptions = null)
    {
        $encoder = new Encoder($this, $container, $encoderOptions);
        $encoder->setLogger($this->logger);
        return $encoder;
    }

    public function encoder(array $schemas = []): Encoder
    {
        $container = new Container($this, $schemas);
        return $this->createEncoder($container, $this->encoderOptions);
    }

}