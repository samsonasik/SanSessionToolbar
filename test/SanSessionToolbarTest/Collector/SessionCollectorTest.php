<?php

namespace SanSessionToolbarTest\Collector;

use PHPUnit_Framework_TestCase;
use SanSessionToolbar\Collector\SessionCollector;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class SessionCollectorTest extends PHPUnit_Framework_TestCase
{
    protected $sessionCollector;

    public function setUp()
    {
        $this->sessionCollector = new SessionCollector;
    }

    public function testGetName()
    {
        $this->assertEquals('session.toolbar', $this->sessionCollector->getName());
    }

    public function testGetPriority()
    {
        $this->assertEquals(10, $this->sessionCollector->getPriority());
    }

    public function testCallCollect()
    {
        $this->sessionCollector->collect(new MvcEvent);
    }

    public function testGetSessionData()
    {
        $sessionContainer = new Container;
        $sessionContainer->word = 'zaf8go6i';
        $sessionContainer->a = array(
            'foo' => 'bar',
            42 => 24,
            'multi' => array(
                'dimensional' => array(
                    'array' => 'foo',
                ),
            ),
        );
        $sessionContainer->bar = 'bar';

        $this->assertEquals(array(
            'word' => 'zaf8go6i',
            'a' => array(
                'foo' => 'bar',
                42 => 24,
                'multi' => array(
                    'dimensional' => array(
                        'array' => 'foo',
                    ),
                ),
            ),
            'bar' => 'bar',
        ), $this->sessionCollector->getSessionData());
    }

    public function tearDown()
    {

    }
}

