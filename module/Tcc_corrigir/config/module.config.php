<?php

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
);