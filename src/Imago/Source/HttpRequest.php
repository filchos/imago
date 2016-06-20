<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Exception\CurlException;
use Filchos\Imago\Exception\CurlTimeoutException;

/**
 * Class for making a http Request and return the response
 */
class HttpRequest extends AbstractSource
{

    /**
     * @var int default timeout in seconds
     */
    const DEFAULT_TIMEOUT = 120;

    /**
     * constructor
     * Possible option arguments
     * - (string) `verb`    the request verb. One of GET, POST, PUT, DELETE (default is GET)
     * - (array)  `headers` an associative array with request headers
     * - (int)    `timeout` the timeout in seconds (default is 120, @see DEFAULT_TIMEOUT)
     * - (array)  `fields`  either query parameters, when method is GET or post parameters otherwise
     * - (string) `url`     the url of the request. (mandatory)
     */
    public function __construct($mixed = [])
    {
        if (is_string($mixed)) {
            $mixed = ['url' => $mixed];
        }
        parent::__construct($mixed);
        $this->options()
            ->setUnlessExists('verb',   'GET')
            ->setUnlessExists('headers', null)
            ->setUnlessExists('timeout', self::DEFAULT_TIMEOUT)
            ->setUnlessExists('fields',  null)
            ->force('url')
        ;
    }

    /**
     * get the response of the http request (and fill some meta values)
     * @return string the http response body
     * Meta values (through the method executeCurl):
     * - (array)  `responseHeaders` all resonse headers as an associative array
     * - (string) `contentType`     the content type of the http response
     * - (int)    `statusCode`      the status code of the http response
     */
    public function get()
    {
        $ch = $this->getCurlHandle();
        return $this->executeCurl($ch);
    }

    /**
     * build up and return a curl handle for the appropriate  request
     * @return resource the curl handle
     */
    protected function getCurlHandle()
    {
        $ch               = curl_init();
        $options          = $this->options();
        $url              = $options->get('url');
        $verb             = strtoupper($options->get('verb'));
        $fields           = $options->get('fields');
        $serializedFields = (is_array($fields) && count($fields)) ? http_build_query($fields) : null;

        if ($verb == 'GET') {
            if ($serializedFields) {
                $separator = (strpos($url, '?') === false) ? '?' : '&';
                $url .= $separator . $serializedFields;
            }
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
            if ($serializedFields) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $serializedFields);
            }
        }

        curl_setopt($ch, CURLOPT_URL,            $url);
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
        return $ch;
    }

    /**
     * execute the curl handle and return the response
     * @param resource the curl handle
     * @return string the response body
     * Meta values:
     * - (array)  `responseHeaders` all resonse headers as an associative array
     * - (string) `contentType`     the content type of the http response
     * - (int)    `statusCode`      the status code of the http response
     */
    protected function executeCurl($ch)
    {
        $meta     = $this->meta();
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

    /**
     * helper method for transforming the response header string into an associative array
     * @param string the header string
     * @return array an associative array with the response headers
     */
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
