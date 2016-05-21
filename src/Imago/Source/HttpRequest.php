<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Exception\CurlException;
use Filchos\Imago\Exception\CurlTimeoutException;

class HttpRequest extends AbstractSource
{

    const DEFAULT_TIMEOUT = 120;

    public function __construct($mixed = [])
    {
        if (is_string($mixed)) {
            $mixed = ['url' => $mixed];
        }
        parent::__construct($mixed);
        $this->options()->setUnlessExists('headers', null);
        $this->options()->setUnlessExists('timeout', self::DEFAULT_TIMEOUT);
    }

    public function get()
    {
        $options = $this->options();
        $meta    = $this->meta();

        $ch      = curl_init();

        curl_setopt($ch, CURLOPT_URL, $options->get('url'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE,        false);
        curl_setopt($ch, CURLOPT_HEADER,         true);
        curl_setopt($ch, CURLOPT_TIMEOUT,        $options->get('timeout'));

        $headers = $options->get('headers', null);
        if ($headers && is_array($headers) and count($headers)) {
            $requestHeaders = [];
            foreach ($headers as $index => $header) {
                $requestHeaders[] = $index. ': ' . $header;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
        }

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            $errno = curl_errno($ch);
            $meta->set('error', $error);
            $meta->set('errno', $errno);
            if ($errno === 28) {
                throw new CurlTimeoutException($error, $errno);
            } else {
                throw new CurlException($error, $errno);
            }
        }

        $headerSize   = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headerString = substr($response, 0, $headerSize);
        $body         = substr($response, $headerSize);

        $meta->set('responseHeaders', $this->parseResponseHeaders($headerString));
        $meta->set('contentType',     curl_getinfo($ch, CURLINFO_CONTENT_TYPE));
        $meta->set('statusCode',      curl_getinfo($ch, CURLINFO_HTTP_CODE));

        return $body;
    }

    protected function parseResponseHeaders($headerString)
    {
        $headers = [];
        foreach (explode("\n", $headerString) as $line) {
            $parts = explode(':', $line, 2);
            if (count($parts) == 2) {
                $headers[trim($parts[0])] = trim($parts[1]);
            }
        }
        return $headers;
    }
}
