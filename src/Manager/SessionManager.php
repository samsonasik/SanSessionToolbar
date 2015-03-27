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
 * A class to manage session data
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
final class SessionManager implements SessionManagerInterface
{
    /**
     * Get Session Data
     * @return array
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
                    $data[$key][$iterator->key()] =  $iterator->current();
                    $iterator->next();
                }
            }
        }

        return $data;
    }

    /**
     * Set/Unset Session by Container and its key
     * @param string $containerName
     * @param string $keysession
     * @param string $value
     * @param bool   $set
     */
    public function sessionSetting($containerName, $keysession, $value = null, $set = true, $new = false)
    {
        if (is_string($containerName) && is_string($keysession)) {
            $container = new Container($containerName);
            if ($new) {
                if ($container->offsetExists($keysession)) {
                    return false;
                } else {
                    $container->offsetSet($keysession, $value);
                    return true;
                }
            } else {
                if ($container->offsetExists($keysession)) {
                    if ($set) {
                        $container->offsetSet($keysession, $value);
                    } else {
                        $container->offsetUnset($keysession);
                    }
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Clear Session
     * @param  null|string $byContainer
     * @return array
     */
    public function clearSession($byContainer = null)
    {
        $sessionData = $this->getSessionData();
        foreach ($sessionData as $containerName => $session) {
            if ($byContainer !== null && $containerName !== $byContainer) {
                continue;
            }

            $container = new Container($containerName);
            foreach ($session as $keysession => $rowsession) {
                $container->offsetUnset($keysession);
            }
        }

        return $this->getSessionData();
    }
}
