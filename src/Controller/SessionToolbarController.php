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
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\NotEmpty;
use Zend\View\Model\JsonModel;
use Zend\View\Renderer\RendererInterface;

/**
 * Session Toolbar Controller.
 *
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
     * Construct.
     *
     * @param RendererInterface       $viewRenderer
     * @param SessionManagerInterface $sessionManager
     */
    public function __construct(RendererInterface $viewRenderer, SessionManagerInterface $sessionManager)
    {
        $this->viewRenderer   = $viewRenderer;
        $this->sessionManager = $sessionManager;
    }

    /**
     * Remove Session by Container and its key.
     */
    public function removesessionAction()
    {
        $success = false;
        $request = $this->getEvent()->getRequest();
        if ($request->isPost()) {
            $containerName = $request->getPost('containerName', 'Default');
            $keysession    = $request->getPost('keysession', '');

            $success = $this->sessionManager
                            ->sessionSetting($containerName, $keysession);
        }

        return new JsonModel(array(
            'success' => $success,
        ));
    }

    /**
     * Reload Session data.
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
     * Clear Session data.
     */
    public function clearsessionAction()
    {
        $sessionData = $this->sessionManager->getSessionData();
        $request = $this->getEvent()->getRequest();
        if ($request->isPost() && !empty($sessionData)) {
            $sessionData = $this->sessionManager->clearSession($request->getPost('byContainer'));
        }

        $renderedContent = $this->viewRenderer
                                ->render('zend-developer-tools/toolbar/session-data-reload', array('san_sessiontoolbar_data' => $sessionData));

        return new JsonModel(array(
            'san_sessiontoolbar_data_renderedContent' => $renderedContent,
        ));
    }

    /**
     * Save Session by Container and its key.
     */
    public function savesessionAction()
    {
        $processSetOrAddSessionData = array('success' => false, 'errorMessage' => '');
        $request = $this->getEvent()->getRequest();

        if ($request instanceof Request && $request->isPost()) {
            $processSetOrAddSessionData = $this->setOrAddSession($request);
        }

        $sessionData     = $this->sessionManager->getSessionData();
        $renderedContent = $this->viewRenderer
                                ->render('zend-developer-tools/toolbar/session-data-reload', array('san_sessiontoolbar_data' => $sessionData));

        return new JsonModel(array(
            'success' => $processSetOrAddSessionData['success'],
            'errorMessage' => $processSetOrAddSessionData['errorMessage'],
            'san_sessiontoolbar_data_renderedContent' => $renderedContent,
        ));
    }

    /**
     * Set or Add Session Data Process.
     *
     * @param Request $request
     *
     * @return bool|string
     */
    private function setOrAddSession(Request $request)
    {
        $containerName = $request->getPost('containerName', 'Default');
        $keysession    = $request->getPost('keysession', '');
        $sessionValue  = $request->getPost('sessionvalue');
        $new           = (bool) $request->getPost('new', false);

        $notEmptyValidator = new NotEmpty();
        if ($notEmptyValidator->isValid($keysession) && $notEmptyValidator->isValid($sessionValue)) {
            $success = $this->sessionManager
                            ->sessionSetting($containerName, $keysession, $sessionValue, array('set' => true, 'new' => $new));

            return array('success' => $success, 'errorMessage' => '');
        }

        return array('success' => false, 'errorMessage' => 'Value is required and can\'t be empty');
    }
}
