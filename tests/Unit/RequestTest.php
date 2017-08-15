<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Mockery;
use StephaneCoinon\IDrive\Support\Container;
use StephaneCoinon\IDrive\Http\Request;
use StephaneCoinon\IDrive\Http\Response;
use Tests\TestCase;

class RequestTest extends TestCase
{
    /** @test */
    function send_method_constructs_a_guzzle_request_with_the_correct_arguments()
    {
        $httpResponse = new HttpResponse(200, ['Content-Type' => 'application/json'], json_encode(['foo' => 'bar']));
        $httpClient = Mockery::mock(\GuzzleHttp\Client::class);
        $httpClient->shouldReceive('request')
            ->once()
            ->with('POST', 'https://server/endpoint', ['form_params' => ['json' => 'yes', 'foo' => 'bar']])
            ->andReturn($httpResponse);
        Container::add(\GuzzleHttp\Client::class, $httpClient);

        $response = (new Request)->send('POST', 'server', 'endpoint', ['foo' => 'bar']);

        $this->assertTrue(true); // keep PHPUnit happy since this test only performs assertions via Mockery
    }
}
