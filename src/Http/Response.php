<?php

namespace StephaneCoinon\IDrive\Http;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use InvalidArgumentException;
use StephaneCoinon\IDrive\Support\Container;
use StephaneCoinon\IDrive\Support\MimeDecoder;

class Response
{
    /** @var string error message when this Response is not OK */
    public $error = '';

    /** @var string response body content */
    public $content = '';

    /** @var array decoded response */
    public $decoded = [];

    /**
     * Create a new Response instance from a GuzzleHttp\Psr7\Response instance.
     *
     * @param  GuzzleHttp\Psr7\Response $response
     * @return static
     */
    public static function createFromGuzzle(GuzzleResponse $response)
    {
        $instance = new static;

        $mimeType = $response->getHeader('Content-Type')[0] ?? '';
        $instance->content = (string) $response->getBody();

        try {
            $decoded = MimeDecoder::decode($instance->content, $mimeType);
        } catch (UnsupportedMimeTypeException $e) {
            $instance->decoded = [];
            $instance->error = 'Response MIME type is not supported: '.$mimeType;
            return $instance;
        } catch (InvalidArgumentException $e) {
            $instance->decoded = [];
            $instance->error = 'Response is not valid '.$mimeType;
            return $instance;
        }

        $instance->decoded = $decoded;
        $instance->error = '';

        if (! $instance->isValid()) {
            $instance->error = '"message" key is missing';
        } elseif (! $instance->isOk()) {
            $instance->error = $instance->get('desc');
        }

        return $instance;
    }

    /**
     * Get a Response attribute.
     *
     * @param  string $attribute attribute name in the data structure
     *                           (XML or JSON) returned by thr API
     * @param  mixed|null $default   default override if attribute doesn't exist
     * @return mixed
     */
    public function get($attribute, $default = null)
    {
        return $this->decoded[$attribute] ?? $default;
    }

    /**
     * Is the Response valid (ie contains expected attributes)?
     *
     * @return boolean
     */
    public function isValid()
    {
        return ! is_null($this->get('message'));
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isOk()
    {
        return $this->get('message') == 'SUCCESS';
    }

    /**
     * Convert Response to array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'ok' => $this->isOk(),
            'error' => $this->error,
            'content' => $this->content,
            'decoded' => $this->decoded,
        ];
    }

    /**
     * Convert Response to array.
     *
     * @return array
     */
    public function __toArray()
    {
        return $this->toArray();
    }
}
