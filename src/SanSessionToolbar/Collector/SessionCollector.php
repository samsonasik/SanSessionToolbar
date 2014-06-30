<?php

namespace SanSessionToolbar\Collector;

use ZendDeveloperTools\Collector\CollectorInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

/**
 * Session Data Collector.
 */
class SessionCollector implements CollectorInterface
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
            if ($row instanceof \Zend\Stdlib\ArrayObject) {
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
