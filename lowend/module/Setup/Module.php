<?php

namespace Setup;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Setup\Model\StoreBank;
use Setup\Model\StoreBankTable;
use Setup\Model\Item;
use Setup\Model\ItemTable;
use Setup\Model\Order;
use Setup\Model\OrderTable;
use Setup\Model\StoreStyle;
use Setup\Model\StoreStyleTable;
use Setup\Model\Products;
use Setup\Model\ProductTable;
use Setup\Model\StoreInfo;
use Setup\Model\StoreInfoTable;
use Setup\Model\StoreCommunity;
use Setup\Model\StoreCommunityTable;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class Module
{
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

    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Setup\Model\OrderTable' =>  function($sm) {
    						$tableGateway = $sm->get('OrderTableGateway');
    						$table = new OrderTable($tableGateway);
    						return $table;
    					},
    					'OrderTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Order());
    						return new TableGateway('orders', $dbAdapter, null, $resultSetPrototype);
    					},
    					'Setup\Model\ProductTable' =>  function($sm) {
    						$tableGateway = $sm->get('ProductTableGateway');
    						$table = new ProductTable($tableGateway);
    						return $table;
    					},
    					'ProductTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Products());
    						return new TableGateway('order_item', $dbAdapter, null, $resultSetPrototype);
    					},
    					'Setup\Model\StoreInfoTable' =>  function($sm) {
    						$tableGateway = $sm->get('StoreInfoTableGateway');
    						$table = new StoreInfoTable($tableGateway);
    						return $table;
    					},
    					'StoreInfoTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new StoreInfo());
    						return new TableGateway('store_info_', $dbAdapter, null, $resultSetPrototype);
    					},
    					'Setup\Model\StoreStyleTable' =>  function($sm) {
    						$tableGateway = $sm->get('StoreStyleTableGateway');
    						$table = new StoreStyleTable($tableGateway);
    						return $table;
    					},
    					'StoreStyleTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new StoreStyle());
    						return new TableGateway('store_style', $dbAdapter, null, $resultSetPrototype);
    					},
    					'Setup\Model\StoreCommunityTable' =>  function($sm) {
    						$tableGateway = $sm->get('StoreCommunityTableGateway');
    						$table = new StoreCommunityTable($tableGateway);
    						return $table;
    					},
    					'StoreCommunityTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new StoreCommunity());
    						return new TableGateway('store_community', $dbAdapter, null, $resultSetPrototype);
    					},
    					'Setup\Model\StoreBankTable' =>  function($sm) {
    						$tableGateway = $sm->get('StoreBankTableGateway');
    						$table = new StoreBankTable($tableGateway);
    						return $table;
    					},
    					'StoreBankTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new StoreBank());
    						return new TableGateway('store_bank', $dbAdapter, null, $resultSetPrototype);
    					},
    					'Setup\Model\ItemTable' =>  function($sm) {
    						$tableGateway = $sm->get('ItemTableGateway');
    						$table = new ItemTable($tableGateway);
    						return $table;
    					},
    					'ItemTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Item());
    						return new TableGateway('item', $dbAdapter, null, $resultSetPrototype);
    					},

    			),
    	);
    }

}
