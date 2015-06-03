<?php

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace SanSessionToolbartest\Collector;

use PHPUnit_Framework_TestCase;
use ReflectionClass;
use SanSessionToolbar\Collector\SessionCollector;
use SanSessionToolbar\Manager\SessionManager;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

/**
 * This class tests SessionCollector class.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionCollectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SessionCollector
     */
    protected $sessionCollector;

    /**
     * @var Container
     */
    protected $sessionContainer;

    /**
     * initialize properties.
     */
    protected function setUp()
    {
        $this->sessionCollector = new SessionCollector(new SessionManager());
        $this->sessionContainer = new Container();
    }

    /**
     * @covers SanSessionToolbar\Collector\SessionCollector::__construct
     */
    public function testConstruct()
    {
        new SessionCollector(new SessionManager());
    }

    /**
     * @covers SanSessionToolbar\Collector\SessionCollector::getName
     */
    public function testGetName()
    {
        $this->assertEquals('session.toolbar', $this->sessionCollector->getName());
    }

    /**
     * @covers SanSessionToolbar\Collector\SessionCollector::getPriority
     */
    public function testGetPriority()
    {
        $this->assertEquals(10, $this->sessionCollector->getPriority());
    }

    /**
     * @covers SanSessionToolbar\Collector\SessionCollector::collect
     */
    public function testCallCollect()
    {
        $this->sessionCollector->collect(new MvcEvent());
    }

    /**
     * @covers SanSessionToolbar\Collector\SessionCollector::getSessionData
     * @runInSeparateProcess
     */
    public function testGetSessionData()
    {
        $this->sessionContainer->word = 'zaf8go6i';
        $this->sessionContainer->a = array(
            'foo' => 'bar',
            42 => 24,
            'multi' => array(
                'dimensional' => array(
                    'array' => 'foo',
                ),
            ),
        );
        $this->sessionContainer->bar = 'bar';

        $this->assertEquals(array(
            'Default' => array(
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
            ),
        ), $this->sessionCollector->getSessionData());
    }

    /**
     * @covers SanSessionToolbar\Collector\SessionCollector::getSessionData
     * @runInSeparateProcess
     */
    public function testGetSessionDataForEmpty()
    {
        $this->sessionContainer->offsetUnset('word');
        $this->sessionContainer->offsetUnset('a');
        $this->sessionContainer->offsetUnset('bar');

        $this->sessionCollector->collect(new MvcEvent());
        $this->assertEquals(array(), $this->sessionCollector->getSessionData());
    }

    protected function tearDown()
    {
        $this->sessionContainer->offsetUnset('word');
        $this->sessionContainer->offsetUnset('a');
        $this->sessionContainer->offsetUnset('bar');
    }
}
