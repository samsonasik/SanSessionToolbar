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

namespace SanSessionToolbarTest\Controller;

use Laminas\Session\Container;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * This class tests SessionToolbarController access.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionToolbarControllerTest extends AbstractHttpControllerTestCase
{
    protected function setUp(): void
    {
        $this->setApplicationConfig([
            'modules' => [
                'Laminas\Router',
                'Laminas\Mvc\Plugin\FlashMessenger',
                'Laminas\DeveloperTools',
                'SanSessionToolbar',
            ],
            'module_listener_options' => [
                'module_paths' => [
                    dirname(__DIR__, 3),
                ],
            ],
        ]);

        parent::setUp();
    }

    public function testAccessRemoveSessionWithoutPostData()
    {
        $this->dispatch('/san-session-toolbar/removesession');
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertEquals('{"success":false}', $this->getResponse()->getBody());
    }

    public function testPostDataWithSessionNotExists()
    {
        $postData = [
            'key' => 'Default',
            'keysession' => 'foo',
        ];
        $this->dispatch('/san-session-toolbar/removesession', 'POST', $postData);
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertEquals('{"success":false}', $this->getResponse()->getBody());
    }

    public function testPostDataWithSessionExists()
    {
        $container = new Container('Default');
        $container->foo = 'fooValue';

        $postData = [
            'key' => 'Default',
            'keysession' => 'foo',
        ];
        $this->dispatch('/san-session-toolbar/removesession', 'POST', $postData);
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertEquals('{"success":true}', $this->getResponse()->getBody());
    }

    public function testReloadWithSessionNonExists()
    {
        $this->dispatch('/san-session-toolbar/reloadsession', 'POST');
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertStringContainsString('No ZF Session Data', $this->getResponse()->getBody());
    }

    public function testReloadWithSessionExists()
    {
        $container = new Container('Default');
        $container->foo = 'fooValue';

        $this->dispatch('/san-session-toolbar/reloadsession', 'POST');
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertStringContainsString('fooValue', $this->getResponse()->getBody());
        $this->assertStringNotContainsString('No ZF Session Data', $this->getResponse()->getBody());
    }

    public function testClearSessionByContainerExecuteCurrentContainerWhenItMet()
    {
        $container = new Container('Default');
        $container->foo = 'fooValue';

        $container = new Container('OtherContainer');
        $container->foo = 'fooValue';

        $postData = [
            'byContainer' => 'Default',
        ];

        $this->dispatch('/san-session-toolbar/clearsession', 'POST', $postData);
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertStringContainsString('OtherContainer', $this->getResponse()->getBody());
        $this->assertStringNotContainsString('Default', $this->getResponse()->getBody());
    }

    public function testClearSessionAllSessionData()
    {
        $container = new Container('Default');
        $container->foo = 'fooValue';

        $container = new Container('OtherContainer');
        $container->foo = 'fooValue';

        $this->dispatch('/san-session-toolbar/clearsession', 'POST');
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertStringNotContainsString('OtherContainer', $this->getResponse()->getBody());
        $this->assertStringNotContainsString('Default', $this->getResponse()->getBody());
    }

    public function testUpdateSessionData()
    {
        $container = new Container('Default');
        $container->foo = 'fooValue';

        $container = new Container('OtherContainer');
        $container->foo = 'fux';

        $postData = [
            'key' => 'Default',
            'keysession' => 'foo',
            'sessionvalue' => 'barbar',
        ];

        $this->dispatch('/san-session-toolbar/savesession', 'POST', $postData);
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertStringContainsString('barbar', $this->getResponse()->getBody());
        $this->assertStringNotContainsString('fooValue', $this->getResponse()->getBody());
    }

    public function testUpdateSessionDataWithEmptyValue()
    {
        $container = new Container('Default');
        $container->foo = 'fooValue';

        $container = new Container('OtherContainer');
        $container->foo = 'fux';

        $postData = [
            'key' => 'Default',
            'keysession' => 'foo',
            'sessionvalue' => '',
        ];

        $this->dispatch('/san-session-toolbar/savesession', 'POST', $postData);
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertStringContainsString('Value is required', $this->getResponse()->getBody());
        $this->assertStringContainsString('fooValue', $this->getResponse()->getBody());
    }

    public function testUpdateSessionDataNotExists()
    {
        $container = new Container('Default');
        $container->foo = 'fooValue';

        $postData = [
            'key' => 'Default',
            'keysession' => 'bazbazbadabum',
            'sessionvalue' => 'barbar',
        ];

        $this->dispatch('/san-session-toolbar/savesession', 'POST', $postData);
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertStringNotContainsString('barbar', $this->getResponse()->getBody());
    }

    public function testNewSessionDataNotExists()
    {
        $container = new Container('Default');
        $container->foo = 'fooValue';

        $postData = [
            'key' => 'Default',
            'keysession' => 'bazbazbadabum',
            'sessionvalue' => 'barbar',
            'new' => 1,
        ];

        $this->dispatch('/san-session-toolbar/savesession', 'POST', $postData);
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertStringContainsString('barbar', $this->getResponse()->getBody());
    }

    public function testNewSessionDataExists()
    {
        $container = new Container('Default');
        $container->foo = 'fooValue';

        $postData = [
            'key' => 'Default',
            'keysession' => 'foo',
            'sessionvalue' => 'barbar',
            'new' => 1,
        ];

        $this->dispatch('/san-session-toolbar/savesession', 'POST', $postData);
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertStringNotContainsString('barbar', $this->getResponse()->getBody());
    }
}
