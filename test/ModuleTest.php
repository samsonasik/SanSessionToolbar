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

namespace SanSessionToolbarTest;

use Laminas\Session\Container;
use Laminas\Stdlib\SplQueue;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use SanSessionToolbar\Module;

/**
 * This class tests Module class.
 */
class ModuleTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var Module
     */
    protected $module;

    protected function setUp(): void
    {
        $this->module = new Module();
    }

    /**
     * @runInSeparateProcess
     */
    public function testOnBootstrapOnSessionNotExists()
    {
        $e = $this->prophesize('Laminas\Mvc\MvcEvent');
        $this->assertNull($this->module->onBootstrap($e->reveal()));
    }

    public function provideHasMessages()
    {
        return [
            [false],
            [true],
        ];
    }

    /**
     * @dataProvider provideHasMessages
     * @runInSeparateProcess
     */
    public function testOnBootstrap($hasMessages)
    {
        $e = $this->prophesize('Laminas\Mvc\MvcEvent');

        if ($hasMessages) {
            new Container();

            $application = $this->prophesize('Laminas\Mvc\Application');
            $eventManager = $this->prophesize('Laminas\EventManager\EventManager');
            $sharedEvm = $this->prophesize('Laminas\EventManager\SharedEventManager');
            $sharedEvmAttach = $sharedEvm->attach(
                'Laminas\Mvc\Controller\AbstractActionController',
                'dispatch',
                [$this->module, 'flashMessengerHandler'],
                2
            );
            $module = $this->module;
            $abstractActionController = $this->prophesize('Laminas\Mvc\Controller\AbstractActionController');
            $flashMessenger = $this->prophesize('Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger');
            $pluginManager  = $this->prophesize('Laminas\Mvc\Controller\PluginManager');

            $sharedEvmAttach->will(function() use ($module, $e, $hasMessages, $abstractActionController, $flashMessenger, $pluginManager) {
                $abstractActionController->getPluginManager()->willReturn($pluginManager)->shouldBeCalled();
                $pluginManager->has('flashMessenger')->willReturn(true)->shouldBeCalled();

                if ($hasMessages) {
                    $namespace = 'flash';
                    $message   = 'a message';
                    $anotherMessage = 'another message';

                    $splQueue = new SplQueue();
                    $splQueue->push($message);
                    $splQueue->push($anotherMessage);

                    $container = new Container('FlashMessenger');
                    $container->offsetSet($namespace, $splQueue);

                    $flashMessenger->getContainer()->willReturn($container)
                                                   ->shouldBeCalled();
                }
                $abstractActionController->plugin('flashMessenger')
                                         ->willReturn($flashMessenger)
                                         ->shouldBeCalled();
                $e->getTarget()
                  ->willReturn($abstractActionController)
                  ->shouldBeCalled();

                $module->flashMessengerHandler($e->reveal());
            });
            $sharedEvmAttach->shouldBeCalled();

            $eventManager->getSharedManager()
                         ->willReturn($sharedEvm)
                         ->shouldBeCalled();
            $application->getEventManager()
                        ->willReturn($eventManager)
                        ->shouldBeCalled();

            $e->getApplication()
              ->willReturn($application)
              ->shouldBeCalled();
        }

        $this->assertNull($this->module->onBootstrap($e->reveal()));
    }

    public function testOnBootstrapWithDoesntHasFlashMessenger()
    {
        $e = $this->prophesize('Laminas\Mvc\MvcEvent');

        $application = $this->prophesize('Laminas\Mvc\Application');
        $eventManager = $this->prophesize('Laminas\EventManager\EventManager');
        $sharedEvm = $this->prophesize('Laminas\EventManager\SharedEventManager');
        $sharedEvmAttach = $sharedEvm->attach(
            'Laminas\Mvc\Controller\AbstractActionController',
            'dispatch',
            [$this->module, 'flashMessengerHandler'],
            2
        );
        $module = $this->module;
        $abstractActionController = $this->prophesize('Laminas\Mvc\Controller\AbstractActionController');
        $flashMessenger = $this->prophesize('Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger');
        $pluginManager  = $this->prophesize('Laminas\Mvc\Controller\PluginManager');

        $sharedEvmAttach->will(function() use ($module, $e, $abstractActionController, $pluginManager) {
            $abstractActionController->getPluginManager()->willReturn($pluginManager)->shouldBeCalled();
            $pluginManager->has('flashMessenger')->willReturn(false)->shouldBeCalled();

            $e->getTarget()
              ->willReturn($abstractActionController)
              ->shouldBeCalled();

            $module->flashMessengerHandler($e->reveal());
        });
        $sharedEvmAttach->shouldBeCalled();

        $eventManager->getSharedManager()
                     ->willReturn($sharedEvm)
                     ->shouldBeCalled();
        $application->getEventManager()
                    ->willReturn($eventManager)
                    ->shouldBeCalled();

        $e->getApplication()
          ->willReturn($application)
          ->shouldBeCalled();

        $this->module->onBootstrap($e->reveal());
    }

    public function testGetConfig()
    {
        $this->assertTrue(is_array($this->module->getConfig()));
    }
}
