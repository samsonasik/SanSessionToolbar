<?php

declare(strict_types=1);

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

use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container;
use Laminas\Stdlib\SplQueue;

/**
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class Module implements ConfigProviderInterface
{
    /**
     * Bootstrap Handle FlashMessenger session show.
     */
    public function onBootstrap(MvcEvent $e)
    {
        $manager = Container::getDefaultManager();
        if (!$manager->sessionExists()) {
            return;
        }

        $app = $e->getApplication();
        /** @var \Laminas\EventManager\SharedEventManagerInterface $sharedEvm */
        $sharedEvm = $app->getEventManager()->getSharedManager();

        $sharedEvm->attach(
            AbstractActionController::class,
            'dispatch',
            [$this, 'flashMessengerHandler'],
            2
        );
    }

    /**
     * Used to duplicate flashMessenger data as it shown and gone.
     */
    private function duplicateFlashMessengerSessionData(Container $container): void
    {
        $flashToolbarContainer = new Container('SanSessionToolbarFlashMessenger');
        foreach ($container->getArrayCopy() as $key => $row) {
            foreach ($row->toArray() as $keyArray => $rowArray) {
                if ($keyArray === 0) {
                    $flashToolbarContainer->$key = new SplQueue();
                }
                $flashToolbarContainer->$key->push($rowArray);
            }
        }
    }

    /**
     * Handle FlashMessenger data to be able to be seen in both "app" and toolbar parts.
     */
    public function flashMessengerHandler(EventInterface $e): void
    {
        /** @var \Laminas\Mvc\Controller\AbstractActionController $controller */
        $controller = $e->getTarget();
        /** Check that getPluginManager is callable 
         *  This handles instances where Module.php from the main project
         *  has additional identifiers added to the EventManager. 
         */
        if (!is_callable([$controller, 'getPluginManager'])) {
            return;
        }
        if (!$controller->getPluginManager()->has('flashMessenger')) {
            return;
        }

        $flash = $controller->plugin('flashMessenger');
        $container = $flash->getContainer();
        $this->duplicateFlashMessengerSessionData($container);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): array
    {
        return include __DIR__.'/../config/module.config.php';
    }
}
