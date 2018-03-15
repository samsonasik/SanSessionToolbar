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

namespace SanSessionToolbarTest\Collector;

use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use SanSessionToolbar\Collector\SessionCollector;
use SanSessionToolbar\Manager\SessionManager;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

/**
 * This class tests SessionCollector class.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionCollectorTest extends TestCase
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

    public function testConstruct()
    {
        $this->assertInstanceOf(SessionCollector::class, new SessionCollector(new SessionManager()));
    }

    public function testGetName()
    {
        $this->assertEquals('session.toolbar', $this->sessionCollector->getName());
    }

    public function testGetPriority()
    {
        $this->assertEquals(10, $this->sessionCollector->getPriority());
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetSessionData()
    {
        $this->sessionContainer->word = 'zaf8go6i';
        $this->sessionContainer->a = [
            'foo' => 'bar',
            42 => 24,
            'multi' => [
                'dimensional' => [
                    'array' => 'foo',
                ],
            ],
        ];
        $this->sessionContainer->bar = 'bar';

        $this->assertEquals([
            'Default' => [
                'word' => 'zaf8go6i',
                'a' => [
                    'foo' => 'bar',
                    42 => 24,
                    'multi' => [
                        'dimensional' => [
                            'array' => 'foo',
                        ],
                    ],
                ],
                'bar' => 'bar',
            ],
        ], $this->sessionCollector->getSessionData());
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetSessionDataForEmpty()
    {
        $this->sessionContainer->offsetUnset('word');
        $this->sessionContainer->offsetUnset('a');
        $this->sessionContainer->offsetUnset('bar');

        // idempotent call on purpose to check data property has "san-session"
        $this->sessionCollector->collect(new MvcEvent());
        $this->sessionCollector->collect(new MvcEvent());

        $this->assertEquals([], $this->sessionCollector->getSessionData());
    }

    protected function tearDown()
    {
        $this->sessionContainer->offsetUnset('word');
        $this->sessionContainer->offsetUnset('a');
        $this->sessionContainer->offsetUnset('bar');
    }
}
