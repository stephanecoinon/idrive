<?php

namespace StephaneCoinon\IDrive\Http;

use GuzzleHttp\Client as Http;
use StephaneCoinon\IDrive\Support\Container;

class Request
{
    /**
     * Send a request to the iDrive API.
     *
     * @param  string $method   HTTP method (GET, POST...)
     * @param  string $server   API server host name
     * @param  string $endpoint
     * @param  array  $params   [description]
     * @return Response
     */
    public function send($method, $server, $endpoint, array $params = [])
    {
        $httpResponse = Container::get(Http::class)->request(
            $method,
            "https://{$server}/{$endpoint}",
            [
                // 'headers' => ['Accept' => 'application/json'], // Ignored by iDrive API
                'form_params' => array_merge(['json' => 'yes'], $params),
            ]
        );

        return Response::createFromGuzzle($httpResponse);
    }

    /**
     * Send a post request.
     *
     * @param  string $server   API server host name
     * @param  string $endpoint
     * @param  array  $params   [description]
     * @return Response
     */
    public function post($server, $endpoint, array $params = [])
    {
        return $this->send('POST', $server, $endpoint, $params);
    }
}
