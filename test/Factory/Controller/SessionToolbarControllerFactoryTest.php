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

namespace SanSessionToolbarTest\Factory\Controller;

use Interop\Container\ContainerInterface;
use PHPUnit_Framework_TestCase;
use SanSessionToolbar\Factory\Controller\SessionToolbarControllerFactory;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * This class tests SessionToolbarControllerFactory class.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionToolbarControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var SessionToolbarControllerFactory */
    protected $factory;

    /** @var ControllerManager */
    protected $controllerManager;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    protected function setUp()
    {
        /** @var ControllerManager $controllerManager */
        $controllerManager = $this->prophesize('Zend\Mvc\Controller\ControllerManager');
        $this->controllerManager = $controllerManager;

        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->prophesize('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new SessionToolbarControllerFactory();
        $this->factory = $factory;
    }

    private function doTestCreateService($serviceLocator)
    {
        if ($serviceLocator->reveal() instanceof ControllerManager) {
            $serviceLocator->getServiceLocator()
                           ->willReturn($this->serviceLocator);
        }

        $mockViewRenderer = $this->prophesize('Zend\View\Renderer\RendererInterface');
        $this->serviceLocator->get('ViewRenderer')
                             ->willReturn($mockViewRenderer)
                             ->shouldBeCalled();

        $sessionManager = $this->prophesize('SanSessionToolbar\Manager\SessionManagerInterface');
        $this->serviceLocator->get('SanSessionManager')
                             ->willReturn($sessionManager)
                             ->shouldBeCalled();

        $result = $this->factory->createService($serviceLocator->reveal());
        $this->assertInstanceOf('SanSessionToolbar\Controller\SessionToolbarController', $result);
    }

    /**
     * @covers SanSessionToolbar\Factory\Controller\SessionToolbarControllerFactory::getParentServiceLocator
     * @covers SanSessionToolbar\Factory\Controller\SessionToolbarControllerFactory::createService
     */
    public function testCreateServiceWithControllerManager()
    {
        $this->doTestCreateService($this->controllerManager);
    }

    /**
     * @covers SanSessionToolbar\Factory\Controller\SessionToolbarControllerFactory::getParentServiceLocator
     * @covers SanSessionToolbar\Factory\Controller\SessionToolbarControllerFactory::createService
     */
    public function testCreateServiceWithServiceLocator()
    {
        $this->doTestCreateService($this->serviceLocator);
    }

    /**
     * @covers SanSessionToolbar\Factory\Controller\SessionToolbarControllerFactory::getParentServiceLocator
     * @covers SanSessionToolbar\Factory\Controller\SessionToolbarControllerFactory::__invoke
     */
    public function testInvoke()
    {
        if ($this->serviceLocator->reveal() instanceof ContainerInterface) {
            $mockViewRenderer = $this->prophesize('Zend\View\Renderer\RendererInterface');
            $this->serviceLocator->get('ViewRenderer')
                                 ->willReturn($mockViewRenderer)
                                 ->shouldBeCalled();

            $sessionManager = $this->prophesize('SanSessionToolbar\Manager\SessionManagerInterface');
            $this->serviceLocator->get('SanSessionManager')
                                 ->willReturn($sessionManager)
                                 ->shouldBeCalled();

            $result = $this->factory->__invoke($this->serviceLocator->reveal(), '');
            $this->assertInstanceOf('SanSessionToolbar\Controller\SessionToolbarController', $result);
        }
    }
}
