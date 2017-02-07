<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 2/7/17
 * Time: 12:28 PM
 */

declare(strict_types=1);

namespace AppServer\Encoder;


use Neomerx\JsonApi\Contracts\Document\ErrorInterface;
use Neomerx\JsonApi\Contracts\Factories\FactoryInterface;
use Symfony\Component\HttpFoundation\Response;

class Encoder extends \Neomerx\JsonApi\Encoder\Encoder
{

    protected const RESPONSE_HEADERS = [
        'Content-Type' => 'application/json'
    ];

    public function response(array $data = []): Response
    {
        return $this->createResponse($this->encodeData($data));
    }

    public function responseWithError(ErrorInterface $error): Response
    {
        return $this->createResponse(
            $this->encodeError($error),
            (int) $error->getStatus()
        );
    }

    protected function createResponse(string $data, int $status = Response::HTTP_OK): Response
    {
        return new Response(
            $data,
            $status,
            self::RESPONSE_HEADERS
        );
    }

    protected static function getFactory(): FactoryInterface
    {
        return new EncoderFactory();
    }

}