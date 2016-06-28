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

namespace SanSessionToolbarTest\Factory\Collector;

use Interop\Container\ContainerInterface;
use PHPUnit_Framework_TestCase;
use SanSessionToolbar\Factory\Collector\SessionCollectorFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * This class tests SessionCollectorFactory class.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionCollectorFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var SessionCollectorFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    protected function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->prophesize('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new SessionCollectorFactory();
        $this->factory = $factory;
    }

    /**
     * @covers SanSessionToolbar\Factory\Collector\SessionCollectorFactory::createService
     */
    public function testCreateService()
    {
        $sessionManager = $this->prophesize('SanSessionToolbar\Manager\SessionManagerInterface');
        $this->serviceLocator->get('SanSessionManager')
                             ->willReturn($sessionManager)
                             ->shouldBeCalled();

        $result = $this->factory->createService($this->serviceLocator->reveal());
        $this->assertInstanceOf('SanSessionToolbar\Collector\SessionCollector', $result);
    }

    /**
     * @covers SanSessionToolbar\Factory\Collector\SessionCollectorFactory::__invoke
     */
    public function testInvoke()
    {
        if ($this->serviceLocator->reveal() instanceof ContainerInterface) {
            $sessionManager = $this->prophesize('SanSessionToolbar\Manager\SessionManagerInterface');
            $this->serviceLocator->get('SanSessionManager')
                                 ->willReturn($sessionManager)
                                 ->shouldBeCalled();

            $result = $this->factory->__invoke($this->serviceLocator->reveal(), '');
            $this->assertInstanceOf('SanSessionToolbar\Collector\SessionCollector', $result);
        }
    }
}
