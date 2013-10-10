<?php

return array(
    'router' => array(
        'routes' => array(
        		'signup' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route'    => '/signup',
        						'defaults' => array(
        								'controller' => 'Top\Controller\Signup',
        								'action'     => 'index',
        						),
        				),
        		),
        		'isError' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route'    => '/isError',
        						'defaults' => array(
        								'controller' => 'Top\Controller\Signup',
        								'action'     => 'isError',
        						),
        				),
        		),

        		'access' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route'    => '/access',
        						'defaults' => array(
        								'controller' => 'Top\Controller\Signup',
        								'action'     => 'Access',
        						),
        				),
        		),
        		'success' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route'    => '/success',
        						'defaults' => array(
        								'controller' => 'Top\Controller\Signup',
        								'action'     => 'success',
        						),
        				),
        		),

        		'forgot_password' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route'    => '/forgot_password',
        						'defaults' => array(
        								'controller' => 'Top\Controller\Login',
        								'action'     => 'forgotPassword',
        						),
        				),
        		),

        		'login' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route'    => '/login',
        						'defaults' => array(
        								'controller' => 'Top\Controller\Login',
        								'action'     => 'index',
        						),
        				),
        		),
        		'logout' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route'    => '/logout',
        						'defaults' => array(
        								'controller' => 'Top\Controller\Login',
        								'action'     => 'logout',
        						),
        				),
        		),

        		'help' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route'    => '/help',
        						'defaults' => array(
        								'controller' => 'Top\Controller\Index',
        								'action'     => 'help',
        						),
        				),
        		),


             'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Top\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'top' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/top',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Top\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),

                    'defaults' => array(
                        '__NAMESPACE__' => 'Top\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
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
            'Top\Controller\Index' => 'Top\Controller\IndexController',
            'Top\Controller\Login' => 'Top\Controller\LoginController',
            'Top\Controller\Signup' => 'Top\Controller\SignupController',
        ),
    ),
    'view_manager' => array(
    'default_suffix' => 'tpl',
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
        		'layout/layout'           => __DIR__ . '/../view/layout/top.tpl',
        		'layout/top_all' => __DIR__ . '/../view/layout/top_all.tpl',
        		'top/index/index' => __DIR__ . '/../view/top/index/index.tpl',
        		'error/404'               => __DIR__ . '/../view/error/404.tpl',
        		'error/index'             => __DIR__ . '/../view/error/index.tpl',
        ),

        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);