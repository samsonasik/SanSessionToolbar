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

namespace SanSessionToolbarTest\Manager;

use PHPUnit_Framework_TestCase;
use SanSessionToolbar\Manager\SessionManager;
use Zend\Session\Container;

/**
 * This class tests SessionManager class.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionMangerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SessionManager
     */
    protected $manager;

    /**
     * initialize properties.
     */
    protected function setUp()
    {
        $this->manager = new SessionManager();
    }

    /**
     * @runInSeparateProcess
     */
    public function testSessionIsNotStartedAlready()
    {
        $manager = new SessionManager();
        $this->assertNull($manager->getSessionData());
    }

    public function testGetSessionData()
    {
        $fooContainer = new Container('Foo');
        $fooContainer->foo = 'fooValue';

        $container      = new Container();
        $container->foo = 'fooValue';

        $sessionData  = [
            'Foo' => [
                'foo' => 'fooValue',
            ],
            'Default' => [
                'foo' => 'fooValue',
            ],
        ];
        $this->assertEquals($sessionData, $this->manager->getSessionData());
    }

    /**
     * @dataProvider provideSessionSettingData
     */
    public function testSessionSetting($container, $keysession, $value, $options, $result)
    {
        $fooContainer = new Container('Foo');
        $fooContainer->foo = 'fooValue';

        $this->assertEquals($result, $this->manager->sessionSetting($container, $keysession, $value, $options));
    }

    public function provideSessionSettingData()
    {
        return [
            ['Default', 'foo', null, [], false],
            ['Default', 'foo', 'fooValue', ['new' => true], true],
            ['Foo', 'foo', 'fooValue', ['new' => true], false],
            ['Foo', 'foo', 'NewFooValue', ['set' => true], true],
            ['Foo', 'foo', 'NewFooValue', ['set' => false], true],
        ];
    }

    /**
     * @dataProvider provideClearSession
     */
    public function testClearSession($byContainer, $result)
    {
        $fooContainer = new Container('Foo');
        $fooContainer->foo = 'fooValue';

        $this->manager->clearSession($byContainer);
        $this->assertEquals($result, $this->manager->getSessionData());
    }

    public function provideClearSession()
    {
        return [
            ['Default', ['Foo' => ['foo' => 'fooValue']]],
            [null, []],
        ];
    }
}
