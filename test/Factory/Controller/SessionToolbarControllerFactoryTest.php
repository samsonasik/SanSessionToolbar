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

use Laminas\View\Renderer\RendererInterface;
use SanSessionToolbar\Manager\SessionManagerInterface;
use SanSessionToolbar\Manager\SessionManager;
use SanSessionToolbar\Controller\SessionToolbarController;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;
use SanSessionToolbar\Factory\Controller\SessionToolbarControllerFactory;

/**
 * This class tests SessionToolbarControllerFactory class.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionToolbarControllerFactoryTest extends TestCase
{
    use ProphecyTrait;

    /** @var SessionToolbarControllerFactory */
    protected $factory;

    /** @var ContainerInterface */
    protected $serviceLocator;

    protected function setUp(): void
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->prophesize(ContainerInterface::class);
        $this->serviceLocator = $serviceLocator;

        $this->factory = new SessionToolbarControllerFactory();
    }

    public function testInvoke()
    {
            $objectProphecy = $this->prophesize(RendererInterface::class);
            $this->serviceLocator->get('ViewRenderer')
                                 ->willReturn($objectProphecy)
                                 ->shouldBeCalled();

            $sessionManager = $this->prophesize(SessionManagerInterface::class);
            $this->serviceLocator->get(SessionManager::class)
                                 ->willReturn($sessionManager)
                                 ->shouldBeCalled();

            $sessionToolbarController = $this->factory->__invoke($this->serviceLocator->reveal());
            $this->assertInstanceOf(SessionToolbarController::class, $sessionToolbarController);
    }
}
