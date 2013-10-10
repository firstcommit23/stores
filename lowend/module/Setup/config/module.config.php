<?php

return array(
    'controllers' => array(
        'invokables' => array(
        	'Setup\Controller\Data' => 'Setup\Controller\DataController',
            'Setup\Controller\Index' => 'Setup\Controller\IndexController',
        	'Setup\Controller\Item' => 'Setup\Controller\ItemController',
        	'Setup\Controller\Order' => 'Setup\Controller\OrderController',
        	'Setup\Controller\Store' => 'Setup\Controller\StoreController',
        	'Setup\Controller\StoreDesign' => 'Setup\Controller\StoreDesignController',
        	'Setup\Controller\User' => 'Setup\Controller\UserController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'setup' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/setup[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Setup\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),

        	'item' => array(
        			'type' => 'segment',
        			'options' => array(
        					'route'    => '/item[/:page][/:action][/:id]',
        					'constraints' => array(
        							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        							'id'     => '[0-9]+',
        							'page'     => '[0-9]+',
        					),
        					'defaults' => array(
        							'controller' => 'Setup\Controller\Item',
        							'action'     => 'index',
        							'page'   => 1,

        					),
        			),
        	),
        	'order' => array(
        			'type' => 'segment',
        			'options' => array(
        					'route'    => '/order[/:page][/:action][/:id]',
        					'constraints' => array(
        							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        							'id'     => '[0-9]+',
        							'page'     => '[0-9]+',
        					),
        					'defaults' => array(
        							'controller' => 'Setup\Controller\Order',
        							'action'     => 'index',
        							'page'   => 1,
        					),
        			),
        	),
        	'store_design' => array(
        			'type' => 'segment',
        			'options' => array(
        					'route'    => '/store_design[/:action]',
        					'constraints' => array(
        							'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        					),
        					'defaults' => array(
        							'controller' => 'Setup\Controller\StoreDesign',
        							'action'     => 'index',
        					),
        			),
        	),
        		'fileupload' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route'    => '/fileupload',
        						'defaults' => array(
        								'controller' => 'Setup\Controller\StoreDesign',
        								'action'     => 'fileUpload',
        						),
        				),
        		),
        		'filelogoupload' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route'    => '/filelogoupload',
        						'defaults' => array(
        								'controller' => 'Setup\Controller\StoreDesign',
        								'action'     => 'fileLogoUpload',
        						),
        				),
        		),

        		'test' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route'    => '/test',
        						'defaults' => array(
        								'controller' => 'Setup\Controller\StoreDesign',
        								'action'     => 'test',
        						),
        				),
        		),
        	'data' => array(
        			'type' => 'Zend\Mvc\Router\Http\Literal',
        			'options' => array(
        					'route'    => '/data',
        					'defaults' => array(
        							'controller' => 'Setup\Controller\Data',
        							'action'     => 'index',
        					),
        			),
        	),
       		'user' => array(
       				'type' => 'Zend\Mvc\Router\Http\Literal',
       				'options' => array(
       						'route'    => '/user',
       						'defaults' => array(
       								'controller' => 'Setup\Controller\User',
       								'action'     => 'index',
       						),
       				),
       				'may_terminate' => true,
       				'child_routes' => array(
       						'default' => array(
       								'type'    => 'Segment',
       								'options' => array(
       										'route'    => '/[:action]',
       										'constraints' => array(
       												'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
       										),
       										'defaults' => array(
       										),
       								),
       						),
       				),
       		),
       		'store' => array(
       				'type' => 'Zend\Mvc\Router\Http\Literal',
       				'options' => array(
       						'route'    => '/store',
       						'defaults' => array(
       								'controller' => 'Setup\Controller\Store',
       								'action'     => 'index',
       						),
       				),
       				'may_terminate' => true,
       				'child_routes' => array(
       						'default' => array(
       								'type'    => 'Segment',
       								'options' => array(
       										'route'    => '/[:action]',
       										'constraints' => array(
       												'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
       										),
       										'defaults' => array(
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
    'view_manager' => array(
    		'default_suffix' => 'tpl',
    		'display_not_found_reason' => true,
    		'display_exceptions'       => true,
    		'doctype'                  => 'HTML5',
    		'not_found_template'       => 'error/404',
    		'exception_template'       => 'error/index',
    		'template_map' => array(
    				'layout/store_design'           => __DIR__ . '/../view/layout/store_design.tpl',
    				'layout/setup'           => __DIR__ . '/../view/layout/setup.tpl',
    				'setup/index/index' => __DIR__ . '/../view/setup/index/index.tpl',
    				'error/404'               => __DIR__ . '/../view/error/404.tpl',
    				'error/index'             => __DIR__ . '/../view/error/index.tpl',
    		),
        'template_path_stack' => array(
            'setup' => __DIR__ . '/../view',
        ),
    ),
);
