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

use PHPUnit_Framework_TestCase;
use SanSessionToolbar\Module;
use Zend\Session\Container;
use Zend\Stdlib\SplQueue;

/**
 * This class tests Module class.
 */
class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Module
     */
    protected $module;

    protected function setUp()
    {
        $this->module = new Module();
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
     * @covers SanSessionToolbar\Module::onBootstrap()
     * @covers SanSessionToolbar\Module::flashMessengerHandler()
     */
    public function testOnBootstrap($hasMessages)
    {
        $e = $this->prophesize('Zend\Mvc\MvcEvent');

        if ($hasMessages) {
            new Container();

            $application = $this->prophesize('Zend\Mvc\Application');
            $eventManager = $this->prophesize('Zend\EventManager\EventManager');
            $sharedEvm = $this->prophesize('Zend\EventManager\SharedEventManager');
            $sharedEvmAttach = $sharedEvm->attach(
                'Zend\Mvc\Controller\AbstractActionController',
                'dispatch',
                [$this->module, 'flashMessengerHandler'],
                2
            );
            $module = $this->module;
            $abstractActionController = $this->prophesize('Zend\Mvc\Controller\AbstractActionController');
            $flashMessenger = $this->prophesize('Zend\Mvc\Controller\Plugin\FlashMessenger');
            $pluginManager  = $this->prophesize('Zend\Mvc\Controller\PluginManager');

            $sharedEvmAttach->will(function() use ($module, $e, $hasMessages, $abstractActionController, $flashMessenger, $pluginManager) {
                $abstractActionController->getPluginManager()->willReturn($pluginManager)->shouldBeCalled();
                $pluginManager->has('flashMessenger')->willReturn(true)->shouldBeCalled();
                
                if ($hasMessages) {
                    $namespace = 'flash';
                    $message   = 'a message';

                    $splQueue = new SplQueue();
                    $splQueue->push($message);

                    $container = new Container('FlashMessenger');
                    $container->offsetSet($namespace, $splQueue);

                    $flashMessenger->setNamespace($namespace)
                                   ->willReturn($flashMessenger)
                                   ->shouldBeCalled();
                    $flashMessenger->addMessage($message)
                                   ->willReturn($flashMessenger)
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

        $this->module->onBootstrap($e->reveal());
    }
    
    public function testOnBootstrapWithDoesntHasFlashMessenger()
    {
        $e = $this->prophesize('Zend\Mvc\MvcEvent');

        $application = $this->prophesize('Zend\Mvc\Application');
        $eventManager = $this->prophesize('Zend\EventManager\EventManager');
        $sharedEvm = $this->prophesize('Zend\EventManager\SharedEventManager');
        $sharedEvmAttach = $sharedEvm->attach(
            'Zend\Mvc\Controller\AbstractActionController',
            'dispatch',
            [$this->module, 'flashMessengerHandler'],
            2
        );
        $module = $this->module;
        $abstractActionController = $this->prophesize('Zend\Mvc\Controller\AbstractActionController');
        $flashMessenger = $this->prophesize('Zend\Mvc\Controller\Plugin\FlashMessenger');
        $pluginManager  = $this->prophesize('Zend\Mvc\Controller\PluginManager');

        $sharedEvmAttach->will(function() use ($module, $e, $abstractActionController, $flashMessenger, $pluginManager) {
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

    /**
     * @covers SanSessionToolbar\Module::getConfig()
     */
    public function testGetConfig()
    {
        $this->assertTrue(is_array($this->module->getConfig()));
    }

    /**
     * @covers SanSessionToolbar\Module::getModuleDependencies()
     */
    public function testGetModuleDependencies()
    {
        $this->assertEquals(['ZendDeveloperTools'], $this->module->getModuleDependencies());
    }
}
