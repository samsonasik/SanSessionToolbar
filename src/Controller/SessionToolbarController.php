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

use SanSessionToolbar\Manager\SessionManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\NotEmpty;
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
     * @var SessionManagerInterface
     */
    private $sessionManager;

    /**
     * Construct
     * @param RendererInterface $viewRenderer
     * @param SessionManager    $sessionManager
     */
    public function __construct(RendererInterface $viewRenderer, SessionManagerInterface $sessionManager)
    {
        $this->viewRenderer   = $viewRenderer;
        $this->sessionManager = $sessionManager;
    }

    /**
     * Remove Session by Container and its key
     */
    public function removesessionAction()
    {
        $success = false;
        if ($this->request->isPost()) {
            $containerName = $this->request->getPost('containerName', 'Default');
            $keysession    = $this->request->getPost('keysession', '');

            $success = $this->sessionManager
                            ->sessionSetting($containerName, $keysession, null, false);
        }

        return new JsonModel(array(
            'success' => $success,
        ));
    }

    /**
     * Reload Session data
     */
    public function reloadsessionAction()
    {
        $sessionData = $this->sessionManager->getSessionData();

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
        $sessionData = $this->sessionManager->getSessionData();

        if ($this->request->isPost() && !empty($sessionData)) {
            $sessionData = $this->sessionManager->clearSession($this->request->getPost('byContainer'));
        }

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
        $success = false;
        $errorMessages = array();

        if ($this->request->isPost()) {
            $containerName = $this->request->getPost('containerName', 'Default');
            $keysession    = $this->request->getPost('keysession', '');
            $sessionValue  = $this->request->getPost('sessionvalue');

            $notEmptyValidator         = new NotEmpty();
            if (! $notEmptyValidator->isValid($keysession) ||  ! $notEmptyValidator->isValid($sessionValue)) {
                $errorMessages[] = 'Value is required and can\'t be empty';
                $success = false;
            } else {
                $new     = $this->request->getPost('new', false);
                $success = $this->sessionManager
                            ->sessionSetting($containerName, $keysession, $sessionValue, true, (bool) $new);
            }
        }

        $sessionData = $this->sessionManager->getSessionData();
        $renderedContent = $this->viewRenderer
                                ->render('zend-developer-tools/toolbar/session-data-reload', array('san_sessiontoolbar_data' => $sessionData));

        return new JsonModel(array(
            'success' => $success,
            'errorMessages' => $errorMessages,
            'san_sessiontoolbar_data_renderedContent' => $renderedContent,
        ));
    }
}
