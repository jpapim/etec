<?php

return array(
    'db' => array(
		'username' => 'root',
<<<<<<< HEAD:config/autoload/development.exemplo.php
        'password' => 'magatti123',
        'dsn' => 'mysql:dbname=bdcatequese;host=localhost',
=======
        'password' => '',
        'dsn' => 'mysql:dbname=bdetec;host=localhost',
>>>>>>> de1815fac8bd91feaadb9fd62e3f5d74a4a2eb1c:config/autoload/development.php
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    'smtp_options' => array(
        'no-reply' => array(
            'name' => 'no-reply',
            'host' => '',
            'port' => 587,
            'connection_class' => 'login',
            'connection_config' => array(
                'ssl' => 'tls',
                'username' => '',
                'password' => ''
            ),
        ),
        'contato' => array(
            'name' => 'contato',
            'host' => '',
            'port' => 587,
            'connection_class' => 'login',
            'connection_config' => array(
                'ssl' => 'tls',
                'username' => '',
                'password' => ''
            ),
        ),
    )
);
