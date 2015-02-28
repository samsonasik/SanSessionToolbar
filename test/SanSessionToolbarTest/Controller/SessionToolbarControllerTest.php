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

use Zend\Session\Container;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * This class tests SessionToolbarController access
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionToolbarControllerTest extends AbstractHttpControllerTestCase
{
    protected function setUp()
    {
        $this->setApplicationConfig(array(
            'modules' => array(
                'SanSessionToolbar',
            ),
            'module_listener_options' => array(
                'module_paths' => array(
                    dirname(dirname(dirname(__DIR__))),
                ),
            ),
        ));

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
        $postData = array(
            'key' => 'Default',
            'keysession' => 'foo',
        );
        $this->dispatch('/san-session-toolbar/removesession', 'POST', $postData);
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertEquals('{"success":false}', $this->getResponse()->getBody());
    }

    public function testPostDataWithSessionExists()
    {
        $container = new Container('Default');
        $container->foo = 'fooValue';

        $postData = array(
            'key' => 'Default',
            'keysession' => 'foo',
        );
        $this->dispatch('/san-session-toolbar/removesession', 'POST', $postData);
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertEquals('{"success":true}', $this->getResponse()->getBody());
    }

    public function testReloadWithSessionNonExists()
    {
        $this->dispatch('/san-session-toolbar/reloadsession', 'POST');
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertContains('No ZF2 Session Data', $this->getResponse()->getBody());
    }

    public function testReloadWithSessionExists()
    {
        $container = new Container('Default');
        $container->foo = 'fooValue';

        $this->dispatch('/san-session-toolbar/reloadsession', 'POST');
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertContains('fooValue', $this->getResponse()->getBody());
        $this->assertNotContains('No ZF2 Session Data', $this->getResponse()->getBody());
    }
}
