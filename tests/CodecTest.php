<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Codec\JsonCodec;
use Filchos\Imago\Codec\PhpSerializeCodec;

class CodecTest extends PHPUnit_Framework_TestCase
{

    public function testJsonCodec()
    {
        $raw     = ['city' => 'Svappavaara'];
        $codec   = new JsonCodec;
        $encoded = $codec->encode($raw);
        $this->assertSame('{"city":"Svappavaara"}', $encoded);
        $decoded = (array) $codec->decode($encoded);
        $this->assertSame($raw, $decoded);
    }

    public function testSerializeCodec()
    {
        $raw     = ['city' => 'Svappavaara'];
        $codec   = new PhpSerializeCodec;
        $encoded = $codec->encode($raw);
        $this->assertSame('a:1:{s:4:"city";s:11:"Svappavaara";}', $encoded);
        $decoded = $codec->decode($encoded);
        $this->assertSame($raw, $decoded);
    }
}
