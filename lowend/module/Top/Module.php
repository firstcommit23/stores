<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Top;
use Top\Model\Signup;
use Top\Model\SignupTable;
use Top\Model\Store;
use Top\Model\StoreTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{

	public function getAutoloaderConfig()
	{
		return array(
				'Zend\Loader\ClassMapAutoloader' => array(
						__DIR__ . '/autoload_classmap.php',
				),
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
						),
				),
		);
	}

    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }



    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Top\Model\StoreTable' =>  function($sm) {
    						$tableGateway = $sm->get('StoreTableGateway');
    						$table = new StoreTable($tableGateway);
    						return $table;
    					},
    					'StoreTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Store());
    						return new TableGateway('store', $dbAdapter, null, $resultSetPrototype);
    					},
    					'Top\Model\SignupTable' =>  function($sm) {
    						$tableGateway = $sm->get('SignupTableGateway');
    						$table = new SignupTable($tableGateway);
    						return $table;
    					},
    					'SignupTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Signup());
    						return new TableGateway('sign_up', $dbAdapter, null, $resultSetPrototype);
    					},
    			),
    	);
    }
}
