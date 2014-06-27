<?php

return array(
    
    'service_manager' => array(
        'invokables' => array(
            'session.toolbar' => 'SanSessionToolbar\Collector\SessionCollector',
        ),
    ),
    
    'view_manager' => array(
        'template_map' => array(
            'zend-developer-tools/toolbar/session-data'
                => __DIR__ . '/../view/zend-developer-tools/toolbar/session-data.phtml',
        ),
    ),
        
    'zenddevelopertools' => array(
        'profiler' => array(
            'collectors' => array(
                'session.toolbar' => 'session.toolbar',
            ),
        ),
        'toolbar' => array(
            'entries' => array(
                'session.toolbar' => 'zend-developer-tools/toolbar/session-data',
            ),
        ),
    ),
    
);