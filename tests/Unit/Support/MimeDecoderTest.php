<?php

namespace Tests;

use StephaneCoinon\IDrive\Support\MimeDecoder;
use Tests\TestCase;

class MimeDecoderTest extends TestCase
{
    /** @test */
    function it_decodes_xml()
    {
        $xml = $this->getFixture('dummy.xml');

        $decoded = MimeDecoder::decode($xml, 'application/xml');

        $this->assertEquals([
            '@attributes' => [
                'foo' => 'bar',
            ]
        ], $decoded);
    }

    /** @test */
    function it_decodes_json()
    {
        $json = json_encode(['foo' => 'bar']);

        $decoded = MimeDecoder::decode($json, 'application/json');

        $this->assertEquals(['foo' => 'bar'], $decoded);
    }

    /**
     * @test
     * @expectedException Exception
     */
    function it_throws_an_exception_when_decoding_an_unsupported_mime_type()
    {
        MimeDecoder::decode('content', 'unsupported/mimetype');
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    function it_throws_an_exception_when_decoding_invalid_json()
    {
        MimeDecoder::json('{"foo":');
    }
}
