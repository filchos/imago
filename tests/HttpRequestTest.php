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
