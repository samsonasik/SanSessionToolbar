<?php

declare(strict_types=1);

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
     * {@inheritdoc}
     */
    public function getSessionData(bool $checkExists = true)
    {
        if ($checkExists) {
            $manager = Container::getDefaultManager();
            if (!$manager->sessionExists()) {
                return;
            }
        }

        $container = new Container();
        $arraysession = $container->getManager()->getStorage()->toArray();

        return $this->collectSessionData($arraysession);
    }

    /**
     * {@inheritdoc}
     */
    private function collectSessionData(array $arraysession) : array
    {
        $data = [];

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
     * {@inheritdoc}
     */
    public function sessionSetting(string $containerName, string $keysession, string $value = null, array $options = []) : bool
    {
        $container = new Container($containerName);
        $new       = $options['new'] ?? false;

        if ($new) {
            return $this->addSession($container, $keysession, $value);
        }

        $set = $options['set'] ?? false;
        return $this->setUnset($container, $keysession, $value, $set);
    }

    /**
     * Add new session data.
     */
    private function addSession(Container $container, string $keysession, string $value) : bool
    {
        if ($container->offsetExists($keysession)) {
            return false;
        }

        $container->offsetSet($keysession, $value);

        return true;
    }

    /**
     * Set/Unset session data.
     */
    private function setUnset(Container $container, string $keysession, string $value = null, bool $set = false) : bool
    {
        if (!$container->offsetExists($keysession)) {
            return false;
        }

        if ($set) {
            $container->offsetSet($keysession, $value);

            return true;
        }

        $container->offsetUnset($keysession);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function clearSession($byContainer = null) : void
    {
        (new Container())->getManager()
             ->getStorage()
             ->clear($byContainer);
    }
}
