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

namespace SanSessionToolbartest;

use PHPUnit_Framework_TestCase;
use SanSessionToolbar\Module;

/**
 * This class tests Module class.
 */
class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Module
     */
    protected $module;

    protected function setUp()
    {
        $this->module = new Module();
    }

    /**
     * @covers SanSessionToolbar\Module::getConfig()
     */
    public function testGetConfig()
    {
        $this->assertTrue(is_array($this->module->getConfig()));
    }

    /**
     * @covers SanSessionToolbar\Module::getModuleDependencies()
     */
    public function testGetModuleDependencies()
    {
        $this->assertEquals(array('ZendDeveloperTools'), $this->module->getModuleDependencies());
    }
}
