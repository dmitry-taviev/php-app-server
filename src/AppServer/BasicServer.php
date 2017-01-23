<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 1/19/17
 * Time: 5:01 PM
 */

declare(strict_types=1);

namespace AppServer;


use React\EventLoop\Factory;
use React\Http\Request;
use React\Http\Response;
use React\Http\Server as Http;
use React\Socket\Server as Socket;
use Silex\Application;

class BasicServer implements Server
{

    /**
     * @var Application
     */
    protected $servedApplication;

    public function serve(Application $application, int $port = self::DEFAULT_PORT, string $host = self::DEFAULT_HOST): void
    {
        $this->servedApplication = $application;
        $loop = Factory::create();
        $socket = new Socket($loop);
        $http = new Http($socket);
        $http->on('request', function(Request $request, Response $response) {
            $this->handleRequest($request, $response);
        });
        $socket->listen($port, $host);
        $loop->run();
    }

    protected function handleRequest(Request $request, Response $response): void
    {
        $contentLength = (int) $request->getHeaders()['Content-Length'];
        $dataReceived = '';
        $totalDataLength = 0;
        $request->on('data', function(string $data) use (&$dataReceived, &$totalDataLength, $contentLength, $request, $response) {
            $dataReceived .= $data;
            $totalDataLength += strlen($data);
            if ($totalDataLength >= $contentLength) {
                $this->handleData($dataReceived, $request, $response);
            }
        });
    }

    protected function handleData(string $data, Request $request, Response $response): void
    {
        $input = $this->createSymfonyRequest($data, $request);
        $output = $this->servedApplication->handle($input);
        $this->servedApplication->terminate($input, $output);
        $response->writeHead(
            $output->getStatusCode(),
            array_map(
                function(array $headerValues) {
                    return $headerValues[0];
                },
                $output->headers->all()
            )
        );
        $response->end($output->getContent());
        $request->close();
    }

    protected function createSymfonyRequest(string $data, Request $request): \Symfony\Component\HttpFoundation\Request
    {
        $method = $request->getMethod();
        $parameters = [];
        if ('GET' === $method) {
            $parameters = $request->getQuery();
        } else {
            parse_str($data, $parameters);
        }

        $symfonyRequest = \Symfony\Component\HttpFoundation\Request::create(
            $request->getPath(),
            $method,
            $parameters,
            [],
            [],
            [],
            $data
        );

        $symfonyRequest->headers->replace($request->getHeaders());

        return $symfonyRequest;
    }

}