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

namespace SanSessionToolbar\Controller;

use Laminas\Http\PhpEnvironment\Request;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Validator\NotEmpty;
use Laminas\View\Model\JsonModel;
use Laminas\View\Renderer\RendererInterface;
use SanSessionToolbar\Manager\SessionManagerInterface;

/**
 * Session Toolbar Controller.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
final class SessionToolbarController extends AbstractActionController
{
    /**
     * Construct.
     */
    public function __construct(private readonly RendererInterface $viewRenderer, private readonly SessionManagerInterface $sessionManager)
    {
    }

    /**
     * Remove Session by Container and its key.
     */
    public function removesessionAction()
    {
        $success = false;
        $request = $this->getEvent()->getRequest();
        if ($request instanceof Request && $request->isPost()) {
            $containerName = $request->getPost('containerName', 'Default');
            $keysession = $request->getPost('keysession', '');

            $success = $this->sessionManager
                            ->sessionSetting($containerName, $keysession);
        }

        return new JsonModel([
            'success' => $success,
        ]);
    }

    /**
     * Reload Session data.
     */
    public function reloadsessionAction()
    {
        $sessionData = $this->sessionManager->getSessionData(false);

        $renderedContent = $this->viewRenderer
                                ->render('laminas-developer-tools/toolbar/session-data-list', ['sessionData' => $sessionData]);

        return new JsonModel([
            'san_sessiontoolbar_data_renderedContent' => $renderedContent,
        ]);
    }

    /**
     * Clear Session data.
     */
    public function clearsessionAction()
    {
        $request = $this->getEvent()->getRequest();
        if ($request instanceof Request && $request->isPost()) {
            $this->sessionManager->clearSession($request->getPost('byContainer'));
        }

        $sessionData = $this->sessionManager->getSessionData();
        $renderedContent = $this->viewRenderer
                                ->render('laminas-developer-tools/toolbar/session-data-list', ['sessionData' => $sessionData]);

        return new JsonModel([
            'san_sessiontoolbar_data_renderedContent' => $renderedContent,
        ]);
    }

    /**
     * Save Session by Container and its key.
     */
    public function savesessionAction()
    {
        $processSetOrAddSessionData = ['success' => false, 'errorMessage' => ''];
        $request = $this->getEvent()->getRequest();

        if ($request instanceof Request && $request->isPost()) {
            $processSetOrAddSessionData = $this->setOrAddSession($request);
        }

        $sessionData = $this->sessionManager->getSessionData();
        $renderedContent = $this->viewRenderer
                                ->render('laminas-developer-tools/toolbar/session-data-list', ['sessionData' => $sessionData]);

        return new JsonModel([
            'success' => $processSetOrAddSessionData['success'],
            'errorMessage' => $processSetOrAddSessionData['errorMessage'],
            'san_sessiontoolbar_data_renderedContent' => $renderedContent,
        ]);
    }

    /**
     * Set or Add Session Data Process.
     *
     *
     * @return array
     */
    private function setOrAddSession(Request $request)
    {
        $containerName = $request->getPost('containerName', 'Default');
        $keysession = $request->getPost('keysession', '');
        $sessionValue = $request->getPost('sessionvalue', '');
        $new = (bool) $request->getPost('new', false);

        $notEmpty = new NotEmpty();
        if ($notEmpty->isValid($keysession) && $notEmpty->isValid($sessionValue)) {
            $success = $this->sessionManager
                            ->sessionSetting($containerName, $keysession, $sessionValue, ['set' => true, 'new' => $new]);

            return ['success' => $success, 'errorMessage' => ''];
        }

        return ['success' => false, 'errorMessage' => "Value is required and can't be empty"];
    }
}
