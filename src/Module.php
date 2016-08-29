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
namespace SanSessionToolbar;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\Stdlib\SplQueue;

/**
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class Module implements ConfigProviderInterface, DependencyIndicatorInterface
{
    /**
     * Bootstrap Handle FlashMessenger session show.
     *
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $manager = Container::getDefaultManager();
        if (!$manager->sessionExists()) {
            return;
        }

        $app = $e->getApplication();
        $sharedEvm = $app->getEventManager()->getSharedManager();

        $sharedEvm->attach(
            'Zend\Mvc\Controller\AbstractActionController',
            'dispatch',
            [$this, 'flashMessengerHandler'],
            2
        );
    }

    /**
     * @param EventInterface
     */
    public function flashMessengerHandler(EventInterface $e)
    {
        $controller = $e->getTarget();
        if (!$controller->getPluginManager()->has('flashMessenger')) {
            return;
        }

        $flash = $controller->plugin('flashMessenger');
        $container = new Container('FlashMessenger');
        $reCreateFlash = $container->getArrayCopy();

        foreach ($reCreateFlash as $key => $row) {
            if ($row instanceof SplQueue) {
                $flashPerNameSpace = $flash->setNamespace($key);
                $valuesMessage = [];
                foreach ($row->toArray() as $keyArray => $rowArray) {
                    $flashPerNameSpace->addMessage($rowArray);
                    $valuesMessage[] = $rowArray;
                }
                $container->offsetSet($key, $valuesMessage);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return include __DIR__.'/../config/module.config.php';
    }

    /**
     * {@inheritdoc}
     */
    public function getModuleDependencies()
    {
        return ['ZendDeveloperTools'];
    }
}
