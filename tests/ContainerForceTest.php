<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Container\LocalContainer;
use Filchos\Imago\Source\Value;

class ContainerForceTest extends PHPUnit_Framework_TestCase
{

    public function testSuccess()
    {
        $container = new LocalContainer;
        $container
            ->set('city', 'Karesuando')
            ->set('region', 'Norrbotten')
            ->set('inhabitants', 303)
            ->force('city')
            ->force('region', '/^(Väster|Norr)botten$/')
            ->force('inhabitants', function($value) { return is_int($value); } )
        ;
    }

    /**
     * @expectedException Filchos\Imago\Exception\MissingKeyException
     */
    public function testMissing()
    {
        $container = new LocalContainer;
        $container->force('city')
        ;
    }

    /**
     * @expectedException Filchos\Imago\Exception\InvalidKeyException
     */
    public function testInvalidPattern()
    {
        $container = new LocalContainer;
        $container
            ->set('region', 'Norrland')
            ->force('region', '/^(Väster|Norr)botten$/')
        ;
    }

    /**
     * @expectedException Filchos\Imago\Exception\InvalidKeyException
     */
    public function testDeniedByCallback()
    {
        $container = new LocalContainer;
        $container
            ->set('inhabitants', 'not so many')
            ->force('inhabitants', function($value) { return is_int($value); } )
        ;
    }

}
