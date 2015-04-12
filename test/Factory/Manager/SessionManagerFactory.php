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

namespace SanSessionToolbartest\Factory\Collector;

use PHPUnit_Framework_TestCase;
use SanSessionToolbar\Factory\Manager\SessionManagerFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * This class tests SessionManagerFactory class.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionManagerFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var SessionManagerFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    protected function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new SessionManagerFactory();
        $this->factory = $factory;
    }

    /**
     * @covers SanSessionToolbar\Factory\Manager\SessionManagerFactory::createService
     * @dataProvider provideConfig
     */
    public function testCreateService($config)
    {
        $this->serviceLocator->expects($this->once())
                             ->method('get')
                             ->with('Config')
                             ->willReturn($config);

        $result = $this->factory->createService($this->serviceLocator);
        $this->assertInstanceOf('SanSessionToolbar\Manager\SessionManager', $result);
    }

    public function provideConfig()
    {
        return array(
            array(array()),
            array(array('san-session-toolbar' => array()))
        );
    }
}
