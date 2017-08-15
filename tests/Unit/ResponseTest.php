<?php

namespace Tests\Unit;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use StephaneCoinon\IDrive\Http\Response;
use Tests\TestCase;

class ResponseTest extends TestCase
{
    /** @test */
    function it_can_be_created_from_a_guzzle_response()
    {
        $json = json_encode(['foo' => 'bar']);
        $guzzleResponse = new GuzzleResponse(200, ['Content-Type' => 'application/json'], $json);

        $response = Response::createFromGuzzle($guzzleResponse);

        $this->assertArraySubset([
            'content' => $json,
        ], $response->toArray());
    }

    /** @test */
    function it_detects_invalid_json_formatting()
    {
        $invalidJson = '{"foo":';
        $guzzleResponse = new GuzzleResponse(200, ['Content-Type' => 'application/json'], $invalidJson);

        $response = Response::createFromGuzzle($guzzleResponse);

        $this->assertEquals([
            'ok' => false,
            'error' => 'Response is not valid application/json',
            'content' => $invalidJson,
            'decoded' => [],
        ], $response->toArray());
    }

    /** @test */
    function it_detects_when_message_key_is_missing_in_the_api_response()
    {
        $decoded = ['foo' => 'bar'];
        $validJson = json_encode($decoded);
        $guzzleResponse = new GuzzleResponse(200, ['Content-Type' => 'application/json'], $validJson);

        $response = Response::createFromGuzzle($guzzleResponse);

        $this->assertEquals([
            'ok' => false,
            'error' => '"message" key is missing',
            'content' => $validJson,
            'decoded' => $decoded,
        ], $response->toArray());
    }

    /** @test */
    function ok_is_true_when_message_key_is_success()
    {
        $decoded = ['message' => 'SUCCESS', 'foo' => 'bar'];
        $validJson = json_encode($decoded);
        $guzzleResponse = new GuzzleResponse(200, ['Content-Type' => 'application/json'], $validJson);

        $response = Response::createFromGuzzle($guzzleResponse);

        $this->assertEquals([
            'ok' => true,
            'error' => '',
            'content' => $validJson,
            'decoded' => $decoded,
        ], $response->toArray());

    }

    /** @test */
    function ok_is_false_when_message_key_is_error()
    {
        $decoded = ['message' => 'ERROR', 'desc' => 'INVALID PASSWORD'];
        $validJson = json_encode($decoded);
        $guzzleResponse = new GuzzleResponse(200, ['Content-Type' => 'application/json'], $validJson);

        $response = Response::createFromGuzzle($guzzleResponse);

        $this->assertEquals([
            'ok' => false,
            'error' => 'INVALID PASSWORD',
            'content' => $validJson,
            'decoded' => $decoded,
        ], $response->toArray());

    }
}
