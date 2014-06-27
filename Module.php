<?php

namespace SanSessionToolbar;

use Zend\Session\Container;

class Module
{
    public function onBootstrap($e)
    {
        $sessionContainer = new Container;
        $sessionContainer->getManager()->start();
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
