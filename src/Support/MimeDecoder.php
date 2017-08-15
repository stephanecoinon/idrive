<?php

namespace StephaneCoinon\IDrive\Support;

use InvalidArgumentException;
use SimpleXMLElement;
use StephaneCoinon\IDrive\Support\Exceptions\UnsupportedMimeTypeException;

class MimeDecoder
{
    /**
     * MIME type decoder methods
     * @var array
     */
    protected static $decoders = [
        // MIME type => decoder method suffix
        'application/xml' => 'xml',
        'application/json' => 'json',
    ];

    /**
     * Decode a data structure according to its MIME type.
     *
     * @param  string $content
     * @param  string $mimeType
     * @return array
     * @throws UnsupportedMimeTypeException when $mimeType os not supported
     * @throws InvalidArgumentException when $content is malformed
     */
    public static function decode($content, $mimeType)
    {
        $decoder = static::$decoders[$mimeType] ?? null;

        if (! $decoder) {
            throw new UnsupportedMimeTypeException($mimeType);
        }

        return static::$decoder($content);
    }

    /**
     * Decode XML.
     *
     * @param  string $xml
     * @return array
     */
    public static function xml($xml)
    {
        return (array) new SimpleXMLElement($xml);
    }

    /**
     * Decode JSON.
     *
     * @param  string $json
     * @return array
     * @throws InvalidArgumentException if $json is malformed JSON
     */
    public static function json($json)
    {
        $decoded = json_decode($json, true);

        if (is_null($decoded)) {
            throw new InvalidArgumentException('Malformed JSON');
        }

        return $decoded;
    }
}
