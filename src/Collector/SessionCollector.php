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

namespace SanSessionToolbar\Collector;

use SanSessionToolbar\Manager\SessionManagerInterface;
use SanSessionToolbar\Manager\SessionManager;
use ZendDeveloperTools\Collector\AbstractCollector;
use Zend\Mvc\MvcEvent;

/**
 * Session Data Collector.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionCollector extends AbstractCollector
{
    /**
     * @var SessionManagerInterface
     */
    protected $sessionManager;

    /**
     * Construct.
     *
     * @param SessionManagerInterface $sessionManager
     */
    public function __construct(SessionManagerInterface $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'session.toolbar';
    }

    /**
     * {@inheritDoc}
     */
    public function getPriority()
    {
        return 10;
    }

    /**
     * {@inheritDoc}
     */
    public function collect(MvcEvent $mvcEvent)
    {
        if (!isset($this->data['san-session'])) {
            $this->data['san-session'] = array();
        }
    }

    /**
     * Get Session data as array.
     *
     * @return array
     */
    public function getSessionData()
    {
        $this->data['san-session'] = $this->sessionManager->getSessionData();

        return $this->data['san-session'];
    }
}
