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

return array(

    'controllers' => array(
        'factories' => array(
            'SanSessionToolbar\Controller\SessionToolbar' => 'SanSessionToolbar\Factory\Controller\SessionToolbarControllerFactory',
        ),
    ),

    'router' => array(
        'routes' => array(
            'san-session-toolbar' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/san-session-toolbar[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'SanSessionToolbar\Controller\SessionToolbar',
                        'action'     => 'removesession',
                    ),
                ),
            ),
        ),
    ),

    'service_manager' => array(
        'invokables' => array(
            'SanSessionManager' => 'SanSessionToolbar\Manager\SessionManager',
        ),
        'factories' => array(
            'session.toolbar' => 'SanSessionToolbar\Factory\Collector\SessionCollectorFactory',
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
            'zend-developer-tools/toolbar/session-data' => __DIR__ . '/../view/zend-developer-tools/toolbar/session-data.phtml',
            'zend-developer-tools/toolbar/session-data-reload' => __DIR__ . '/../view/zend-developer-tools/toolbar/session-data-reload.phtml',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
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
