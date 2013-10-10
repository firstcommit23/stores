<?php
return array(
    'modules' => array(
        'SmartyModule',
        'Top',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/'.getenv('APPLICATION_ENV').'/autoload/{,*.}{global,local}.php',
            'config/'.getenv('APPLICATION_ENV').'/autoload/'.getenv('APPLICATION_CONFIG').'.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
