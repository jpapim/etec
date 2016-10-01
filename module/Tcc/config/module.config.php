<?php
/**
 * Created by PhpStorm.
 * User: EduFerr
 * Date: 19/09/2016
 * Time: 16:13
 */

return array(
    'router' => array(
        'routes' => array(
            'tcc' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/tcc/:action[/:id][/:aux]',
                    'defaults' => array(
                        'controller' => 'tcc',
                        'action'     => 'index',
                    ),
                ),

            ),
            'tcc-tcc' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/tcc-tcc/:action[/:id][/:aux]',
                    'defaults' => array(
                        'controller' => 'tcc-tcc',
                        'action'     => 'index',
                    ),
                ),

            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'tcc' => 'Tcc\Controller\TccController',
            'tcc-tcc' => 'Tcc\Controller\TccController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);