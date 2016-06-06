<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\HttpRequest;

class HttpRequestTest extends PHPUnit_Framework_TestCase
{

    public function testRead()
    {
        $imago  = new HttpRequest(['url' => 'http://localhost:8000/simple-test.php']);
        $result = $imago->get();
        $this->assertSame('Kiruna', $result);
    }

    public function testMeta()
    {
        $imago  = new HttpRequest(['url' => 'http://localhost:8000/meta-test.php']);
        $result = $imago->get();
        $meta = $imago->meta();
        $this->assertSame('Torneträsk', $meta->get('responseHeaders')['X-Unittest']);
        $this->assertSame(200, $meta->get('statusCode'));
        $this->assertSame('text/plain; charset=utf-8', $meta->get('contentType'));
    }

    public function testReadWithShortConstructor()
    {
        $imago  = new HttpRequest('http://localhost:8000/simple-test.php');
        $result = $imago->get();
        $this->assertSame('Kiruna', $result);
    }

    public function testHeaders()
    {
        $url     = 'http://localhost:8000/header-test.php';
        $headers = ['X-Imagotest' => 'Rsnqtl`m'];
        $imago   = new HttpRequest([
            'url'  => 'http://localhost:8000/header-plus-one-test.php',
            'headers' => $headers
        ]);
        $this->assertSame('Storuman', $imago->get());
    }

    public function testVerbs()
    {
        $url = 'http://localhost:8000/verb-test.php';

        $imago = new HttpRequest(['url'  => $url, 'verb' => 'GET']);
        $this->assertSame('GET', $imago->get());

        $imago = new HttpRequest(['url'  => $url]);
        $this->assertSame('GET', $imago->get());

        $imago = new HttpRequest(['url'  => $url, 'verb' => 'POST']);
        $this->assertSame('POST', $imago->get());

        $imago = new HttpRequest(['url'  => $url, 'verb' => 'PUT']);
        $this->assertSame('PUT', $imago->get());

        $imago = new HttpRequest(['url'  => $url, 'verb' => 'DELETE']);
        $this->assertSame('DELETE', $imago->get());
    }

    public function testFields()
    {
        // no query string, but a get param
        $url    = 'http://localhost:8000/fields-test.php';
        $imago  = new HttpRequest(['url' => $url, 'fields' => ['city' => 'Ammarnäs']]);
        $result = json_decode($imago->get());
        $this->assertSame('Ammarnäs', $result->GET->city);

        // query string and a get param
        $url    = 'http://localhost:8000/fields-test.php?queryString=1';
        $imago  = new HttpRequest(['url' => $url, 'fields' => ['city' => 'Ammarnäs']]);
        $result = json_decode($imago->get());
        $this->assertSame('Ammarnäs', $result->GET->city);
        $this->assertSame('1', $result->GET->queryString);

        // query string and a post param
        $url    = 'http://localhost:8000/fields-test.php?queryString=1';
        $imago  = new HttpRequest(['url' => $url, 'fields' => ['city' => 'Ammarnäs'], 'verb' => 'POST']);
        $result = json_decode($imago->get());
        $this->assertSame('Ammarnäs', $result->POST->city);
        $this->assertSame('1', $result->GET->queryString);
    }

    /**
     * @expectedException Filchos\Imago\Exception\CurlException
     * @expectedExceptionCode 6
     */
    public function testWithNonExistingUrl()
    {
        $imago  = new HttpRequest('http://no-host/');
        $result = $imago->get();
    }

    /**
     * @group timeout
     * @expectedException Filchos\Imago\Exception\CurlTimeoutException
     * @expectedExceptionCode 28
     */
    public function testWithTimeout()
    {
        $imago  = new HttpRequest(['url' => 'http://localhost:8000/slow-test.php', 'timeout' => 1]);
        $result = $imago->get();
    }

    /**
     * @group timeout
     */
    public function testWithCaughtTimeout()
    {
        $imago = (new HttpRequest(['url' => 'http://localhost:8000/slow-test.php', 'timeout' => 1]))
            ->to('Filchos\\Imago\\Transformer\\ExceptionCatcher')
        ;
        $result = $imago->get();
        $this->assertNull($result);

        $innerMeta = $imago->inner()->meta();

        $this->assertSame(28, $innerMeta->get('errno'));
        $this->assertSame('Operation timed out', substr($innerMeta->get('error'), 0, 19));
    }
}
