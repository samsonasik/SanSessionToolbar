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
namespace SanSessionToolbar\Collector;

use ZendDeveloperTools\Collector\CollectorInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\Stdlib\ArrayObject;

/**
 * Session Data Collector.
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class SessionCollector implements CollectorInterface
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
         // this name must same with *collectors* name in the configuration
        return 'session.toolbar';
    }

    /**
     * {@inheritDoc}
     */
    public function getPriority()
    {
        return 10;
    }

    /**
     * {@inheritDoc}
     */
    public function collect(MvcEvent $mvcEvent)
    {
    }
    
    public function getSessionData()
    {
        $container = new Container;
        $container->getManager()->start();
        
        $arraysession = $container->getManager()->getStorage()->toArray();
        
        $data = array();
        foreach($arraysession as $key => $row) {
            if ($row instanceof ArrayObject) {
                $iterator = $row->getIterator();
                while($iterator->valid()) {
                    $data[$iterator->key()] =  $iterator->current() ;
                    $iterator->next();
                }
            }
        }
        
        return $data;
    }
}
