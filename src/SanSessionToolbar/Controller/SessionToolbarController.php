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
namespace SanSessionToolbar\Controller;

use SanSessionToolbar\Collector\SessionCollector;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\View\Renderer\RendererInterface;

/**
 * Session Toolbar Controller
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
final class SessionToolbarController extends AbstractActionController
{
    /**
     * @var RendererInterface
     */
    private $viewRenderer;

    /**
     * Construct
     * @param RendererInterface $viewRenderer
     */
    public function __construct(RendererInterface $viewRenderer)
    {
        $this->viewRenderer = $viewRenderer;
    }

    /**
     * Remove Session by Container and its key
     */
    public function removesessionAction()
    {
        $success = $this->sessionSetting('containerName', 'keysession', null, $this->request, false);

        return new JsonModel(array(
            'success' => $success,
        ));
    }

    /**
     * Reload Session data
     */
    public function reloadsessionAction()
    {
        $sessionCollector = new SessionCollector();
        $sessionCollector->collect(new MvcEvent());
        $sessionData = $sessionCollector->getSessionData();

        $renderedContent = $this->viewRenderer
                                ->render('zend-developer-tools/toolbar/session-data-reload', array('san_sessiontoolbar_data' => $sessionData));

        return new JsonModel(array(
            'san_sessiontoolbar_data_renderedContent' => $renderedContent,
        ));
    }

    /**
     * Clear Session data
     */
    public function clearsessionAction()
    {
        $sessionCollector = new SessionCollector();
        $sessionCollector->collect(new MvcEvent());
        $sessionData = $sessionCollector->getSessionData();

        if ($this->request->isPost() && !empty($sessionData)) {
            foreach ($sessionData as $containerName => $session) {
                $container = new Container($containerName);
                foreach ($session as $keysession => $rowsession) {
                    if (!$this->request->getPost('byContainer')) {
                        $container->offsetUnset($keysession);
                    } else {
                        if ($containerName === $this->request->getPost('byContainer')) {
                            $container->offsetUnset($keysession);
                        } else {
                            // skip current container check
                            // continue to next container
                            continue 2;
                        }
                    }
                }
            }
        }

        // re-collect Session Data
        $sessionCollector = new SessionCollector();
        $sessionCollector->collect(new MvcEvent());
        $sessionData = $sessionCollector->getSessionData();

        $renderedContent = $this->viewRenderer
                                ->render('zend-developer-tools/toolbar/session-data-reload', array('san_sessiontoolbar_data' => $sessionData));

        return new JsonModel(array(
            'san_sessiontoolbar_data_renderedContent' => $renderedContent,
        ));
    }

    /**
     * Save Session by Container and its key
     */
    public function savesessionAction()
    {
        $success = $this->sessionSetting('containerName', 'keysession', 'sessionvalue', $this->request, true);

        $sessionCollector = new SessionCollector();
        $sessionCollector->collect(new MvcEvent());
        $sessionData = $sessionCollector->getSessionData();

        $renderedContent = $this->viewRenderer
                                ->render('zend-developer-tools/toolbar/session-data-reload', array('san_sessiontoolbar_data' => $sessionData));

        return new JsonModel(array(
            'success' => $success,
            'san_sessiontoolbar_data_renderedContent' => $renderedContent,
        ));
    }

    /**
     * Set/Unset Session by Container and its key
     * @param string  $containerName
     * @param string  $keysesion
     * @param string  $value
     * @param Request $request
     * @param bool    $set
     */
    private function sessionSetting($containerName, $keysesion, $value = null, Request $request, $set = true)
    {
        $success = false;
        if ($request->isPost()) {
            $containerName = $request->getPost($containerName, 'Default');
            $keysession    = $request->getPost($keysesion, '');
            if (is_string($containerName) && is_string($keysession)) {
                $container = new Container($containerName);
                if ($container->offsetExists($keysession)) {
                    if ($set) {
                        $container->offsetSet($keysession, $request->getPost($value, ''));
                    } else {
                        $container->offsetUnset($keysession);
                    }
                    $success = true;
                }
            }
        }

        return $success;
    }
}
