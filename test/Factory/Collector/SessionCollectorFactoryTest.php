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

use SanSessionToolbar\Manager\SessionManagerInterface;
use SanSessionToolbar\Manager\SessionManager;
use SanSessionToolbar\Collector\SessionCollector;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;
use SanSessionToolbar\Factory\Collector\SessionCollectorFactory;

/**
 * This class tests SessionCollectorFactory class.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionCollectorFactoryTest extends TestCase
{
    use ProphecyTrait;

    /** @var SessionCollectorFactory */
    protected $factory;

    /** @var ContainerInterface */
    protected $serviceLocator;

    protected function setUp(): void
    {
        /** @var ContainerInterface $serviceLocator */
        $serviceLocator = $this->prophesize(ContainerInterface::class);
        $this->serviceLocator = $serviceLocator;

        $factory = new SessionCollectorFactory();
        $this->factory = $factory;
    }

    public function testInvoke()
    {
        $sessionManager = $this->prophesize(SessionManagerInterface::class);
        $this->serviceLocator->get(SessionManager::class)
                                ->willReturn($sessionManager)
                                ->shouldBeCalled();

        $sessionCollector = $this->factory->__invoke($this->serviceLocator->reveal());
        $this->assertInstanceOf(SessionCollector::class, $sessionCollector);
    }
}
