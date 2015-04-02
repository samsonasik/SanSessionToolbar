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

namespace SanSessionToolbartest\Manager;

use PHPUnit_Framework_TestCase;
use Zend\Session\Container;
use SanSessionToolbar\Manager\SessionManager;

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

        // existing container
        $fooContainer = new Container('Foo');
        $fooContainer->foo = 'fooValue';
    }

    public function testGetSessionData()
    {
        $container      = new Container();
        $container->foo = 'fooValue';

        $sessionData  = array(
            'Foo' => array(
                'foo' => 'fooValue',
            ),
            'Default' => array(
                'foo' => 'fooValue',
            ),
        );
        $this->assertEquals($sessionData, $this->manager->getSessionData());
    }

    /**
     * @dataProvider provideSessionSettingData
     */
    public function testSessionSetting($container, $keysession, $value, $options, $result)
    {
        $this->assertEquals($result, $this->manager->sessionSetting($container, $keysession, $value, $options));
    }

    public function provideSessionSettingData()
    {
        return array(
            array('Default', 'foo', null, array(), false),
            array('Default', 'foo', 'fooValue', array('new' => true), true),
            array('Foo', 'foo', 'fooValue', array('new' => true), false),
            array('Foo', 'foo', 'NewFooValue', array('set' => true), true),
            array('Foo', 'foo', 'NewFooValue', array('set' => false), true),
        );
    }

    /**
     * @dataProvider provideClearSession
     */
    public function testClearSession($byContainer, $result)
    {
        $this->assertEquals($result, $this->manager->clearSession($byContainer));
    }

    public function provideClearSession()
    {
        return array(
            array('Default', array('Foo' => array('foo' => 'fooValue'))),
            array(null, array()),
        );
    }
}
