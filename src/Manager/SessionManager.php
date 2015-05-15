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

namespace SanSessionToolbar\Manager;

use Zend\Session\Container;
use Zend\Stdlib\ArrayObject;

/**
 * A class to manage session data.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
final class SessionManager implements SessionManagerInterface
{
    /**
     * {@inheritDoc}
     */
    public function getSessionData()
    {
        $data = array();

        $container = new Container();
        $container->getManager()->start();

        $arraysession = $container->getManager()->getStorage()->toArray();

        foreach ($arraysession as $key => $row) {
            if ($row instanceof ArrayObject) {
                $iterator = $row->getIterator();
                while ($iterator->valid()) {
                    $data[$key][$iterator->key()] = $iterator->current();
                    $iterator->next();
                }
            }
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function sessionSetting($containerName, $keysession, $value = null, $options = array())
    {
        $container = new Container($containerName);
        $set = (!empty($options['set'])) ? $options['set'] : false;
        $new = (!empty($options['new'])) ? $options['new'] : false;

        if ($new) {
            return $this->addSession($container, $keysession, $value);
        }

        return $this->setUnset($container, $keysession, $value, $set);
    }

    /**
     * Add new session data.
     *
     * @param Container $container
     * @param string    $keysession
     * @param string    $value
     *
     * @return bool
     */
    private function addSession(Container $container, $keysession, $value)
    {
        if ($container->offsetExists($keysession)) {
            return false;
        }

        $container->offsetSet($keysession, $value);

        return true;
    }

    /**
     * Set/Unset session data.
     *
     * @param Container   $container
     * @param string      $keysession
     * @param null|string $value
     * @param false|bool  $set
     *
     * @return bool
     */
    private function setUnset(Container $container, $keysession, $value = null, $set = false)
    {
        if ($container->offsetExists($keysession)) {
            if ($set) {
                $container->offsetSet($keysession, $value);
            } else {
                $container->offsetUnset($keysession);
            }

            return true;
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function clearSession($byContainer = null)
    {
        $container = new Container();
        $container->getManager()->getStorage()->clear($byContainer);

        return $this->getSessionData();
    }
}
