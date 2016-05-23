<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Transformer\CachedTransformer;
use Filchos\Imago\Transformer\TwoTrialsCachedTransformer;

class TwoTrialCachedTransformerTest extends PHPUnit_Framework_TestCase
{

    const FIVE_MINUTES = 300;
    const HALF_AN_HOUR = 1800;
    const A_WHOLE_HOUR = 3600;
    const A_WHOLE_DAY  = 86400;

    public function setUp()
    {
        $this->cachePath = __DIR__ . '/cache/';
        $this->cache = new DateableFileCache([
            'path' => $this->cachePath,
            'ttl'  => self::FIVE_MINUTES
        ]);
        $this->cache->flush();
        (new OnceSource())->reset();

        $this->options = [
            'cache' => $this->cache,
            'key'  => '2trialfile',
            'ttl2'  => self::A_WHOLE_HOUR,
        ];
    }

    /**
     * @expectedException OnceSourceException
     */
    public function testTwiceAndFail()
    {
        (new OnceSource())->get();
        (new OnceSource())->get();
    }

    public function testFirstRules()
    {

        $values = [];

        foreach([0, 1] as $index) {
            $imago = new OnceSource();
            $imago = new TwoTrialsCachedTransformer($imago, $this->options);
            $values[$index] = $imago->get();
        }
        $this->assertSame($values[0], $values[1]);
    }

    /**
     * @expectedException OnceSourceException
     */
    public function testSecondFailsBecauseOfOnlyOneTrial()
    {

        $values = [];

        foreach([0, 1] as $index) {
            $imago = new OnceSource();
            $imago = new CachedTransformer($imago, $this->options);
            $values[$index] = $imago->get();
            $this->cache->redate('2trialfile', - self::HALF_AN_HOUR);
        }
        $this->assertSame($values[0], $values[1]);
    }

    public function testSecondSucceeds()
    {

        $values = [];

        foreach([0, 1] as $index) {
            $imago = new OnceSource();
            $imago = new TwoTrialsCachedTransformer($imago, $this->options);
            $values[$index] = $imago->get();
            $this->cache->redate('2trialfile', - self::HALF_AN_HOUR);
        }
        $this->assertSame($values[0], $values[1]);
    }

    /**
     * @expectedException Filchos\Imago\Exception\MissingKeyException
     */
    public function testSecondFailsDueToAncientCacheFile()
    {

        $values = [];

        foreach([0, 1] as $index) {
            $imago = new OnceSource();
            $imago = new TwoTrialsCachedTransformer($imago, $this->options);
            $values[$index] = $imago->get();
            $this->cache->redate('2trialfile', - self::A_WHOLE_DAY);
        }
        $this->assertSame($values[0], $values[1]);
    }

}
