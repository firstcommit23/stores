<?php

namespace Setup\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OrderController extends AbstractActionController
{
	/*
	 *  Order Table
	 */
	protected $orderTable;

	public function getOrderTable()
	{
		if (!$this->orderTable) {
			$sm = $this->getServiceLocator();
			$this->orderTable = $sm->get('Setup\Model\OrderTable');
		}
		return $this->orderTable;
	}

	/* Store Table */
	protected $storeTable;

	public function getStoreTable()
	{
		if (!$this->storeTable) {
			$sm = $this->getServiceLocator();
			$this->storeTable = $sm->get('Top\Model\StoreTable');
		}
		return $this->storeTable;
	}

	/*
	 *  Product Table
	*/
	protected $productTable;

	public function getProductTable()
	{
		if (!$this->productTable) {
			$sm = $this->getServiceLocator();
			$this->productTable = $sm->get('Setup\Model\ProductTable');
		}
		return $this->productTable;
	}

	/*
	 * オーダー管理。一覧が表示される。
	 */
    public function indexAction()
    {

    	$this->layout('layout/setup');

    	// 必要な変数を作る
    	$view = new ViewModel;
    	$order = array();
    	$request = $this->getRequest();
		$page = (int) $this->params()->fromRoute('page', 1);

		// Requestがあれば（ソーロー）
		if($request->isPost()){
			$action = $request->getPost('action');
			$searchValue = $request->getPost('searchValue');
			$order = $this->getOrderTable()->fetchSearch($page, $action, $searchValue);

			// 各ソードーによって、検索値をアサインする
			if($action =='order_date'){
				$view->selectDay = $searchValue;
			}else if($action == 'state'){
				$view->selectState = $searchValue;
			}else if($action =='searchStr'){
				$view->searchStr = $searchValue;
			}

		// Requestが無ければ（全体を見る）
		}else{
			$order = $this->getOrderTable()->fetchAll($page);
		}

		/*
		 *  期間のところをセットする
		*/
		$dayList = array();
		$today = date("Y-m");
		// サービス開始日
		$startDay = date("Y-m", mktime(0,0,0,11,0,2012));

		while($today != $startDay){
			$dayList[] = $today;
			$today = date("Y-m", strtotime("-1 month" , strtotime($today)));
		}
		$dayList[]=$startDay;

		//Paging
		$pageView = $order->getPages();

		$view->dayList = $dayList;
		$view->order = $order;
		$view->page = $pageView;

    	return $view;
	}

	public function detailAction()
	{
		$this->layout('layout/setup');

		$order_id = (int) $this->params()->fromRoute('id', 0);
		if (!$order_id) {
			return $this->redirect()->toRoute('order', array(
					'action' => 'index'
			));
		}

		$token =  base64_decode($_COOKIE['AUTH_TOKEN'] );
		$store_date = $this->getStoreTable()->getStore($token);
		$store_id = $store_date->store_id;

		// Products date
		$products = $this->getProductTable()->getProduct($order_id );

		// Order date
		$order = $this->getOrderTable()->getOrder($store_id, $order_id );

		return new ViewModel(array(
				'order' => $order,
				'products' => $products,
		));
	}

	public function executeAction()
	{
		$request = $this->getRequest();

		if( $request->isPost() ){
			$order_id = $request->getPost()->ORDERID;
			$status = $request->getPost()->STATUE;

			$token = base64_decode($_COOKIE['AUTH_TOKEN'] );
			$store_date = $this->getStoreTable()->getStore($token);
			$store_id = $store_date->store_id;

			$res = $this->getOrderTable()->excuteState($store_id, $order_id, $status );
			if(!$res){
				print "not thing";
				exit;
			}
			return $this->redirect()->toRoute('order', array('action'=>'detail', 'id' => $order_id));
		}
	}
}
