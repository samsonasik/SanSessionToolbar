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
namespace SanSessionToolbarTest\Service;

use PHPUnit_Framework_TestCase;
use SanSessionToolbar\Service\SessionManager;
use SanSessionToolbar\Collector\SessionCollector;
use Zend\Session\Container;

/**
 * This class tests SessionManager class
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SessionManager
     */
    protected $sessionManager;

    /**
     * initialize properties
     */
    protected function setUp()
    {
        $this->sessionManager = new SessionManager(new SessionCollector());
    }

    /**
     * @covers SanSessionToolbar\Service\SessionManager::__construct()
     */
    public function testConstruct()
    {
        new SessionManager(new SessionCollector());
    }

    /**
     * @covers SanSessionToolbar\Service\SessionManager::getSessionData()
     */
    public function testGetSessionData()
    {
        $this->assertTrue(is_array($this->sessionManager->getSessionData()));
    }

    /**
     * @covers SanSessionToolbar\Service\SessionManager::sessionSetting()
     */
    public function testSessionSettingSessionExists()
    {
        $container = new Container('Boom');
        $container->foofoo = 'fooValue';

        $this->assertTrue($this->sessionManager->sessionSetting('Boom', 'foofoo', 'bar', true));
        $this->assertTrue($this->sessionManager->sessionSetting('Boom', 'foofoo', null, false));
    }

    /**
     * @covers SanSessionToolbar\Service\SessionManager::sessionSetting()
     */
    public function testSessionSettingSessionNotExists()
    {
        $this->assertFalse($this->sessionManager->sessionSetting('Boom', 'foofoo', 'bar', true));
        $this->assertFalse($this->sessionManager->sessionSetting('Boom', 'foofoo', null, false));
    }

    /**
     * @covers SanSessionToolbar\Service\SessionManager::clearSession()
     */
    public function testClearSessionExists()
    {
        $this->sessionManager->clearSession(false);
        $this->sessionManager->clearSession('Boom');
    }

    /**
     * @covers SanSessionToolbar\Service\SessionManager::clearSession()
     */
    public function testClearSessionNotExists()
    {
        $container = new Container('Boom');
        $container->foofoo = 'fooValue';
        $this->sessionManager->clearSession(false);

        $container = new Container('Boom');
        $container->foofoo = 'fooValue';
        $this->sessionManager->clearSession('Boom');
    }
}
