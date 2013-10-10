<?php

namespace Setup\Controller;

use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Top\Model\Store;
use Setup\Model\StoreInfo;
use Setup\Model\StoreCommunity;

class StoreController extends AbstractActionController
{
	protected $storeTable;
	public function getStoreTable()
	{
		if (!$this->storeTable) {
			$sm = $this->getServiceLocator();
			$this->storeTable = $sm->get('Top\Model\StoreTable');
		}
		return $this->storeTable;
	}

	protected $storeInfoTable;
	public function getStoreInfoTable()
	{
		if (!$this->storeInfoTable) {
			$sm = $this->getServiceLocator();
			$this->storeInfoTable = $sm->get('Setup\Model\StoreInfoTable');
		}
		return $this->storeInfoTable;
	}

	protected $storeCommunityTable;
	public function getStoreCommunityTable()
	{
		if (!$this->storeCommunityTable) {
			$sm = $this->getServiceLocator();
			$this->storeCommunityTable = $sm->get('Setup\Model\StoreCommunityTable');
		}
		return $this->storeCommunityTable;
	}

	/* Store 情報を持っている */
	protected $store;
	public function getStore()
	{
		if(!$this->store) {
			$token =  base64_decode($_COOKIE['AUTH_TOKEN'] );
			$this->store = $this->getStoreTable()->getStore($token);
		}
		return $this->store;
	}


    public function indexAction()
    {
    	$this->layout('layout/setup');
    	$request = $this->getRequest();

    	$storeInfo = $this->getStoreInfoTable()->getStoreInfo($this->getStore()->store_id);
    	$storeSns = $this->getStoreCommunityTable()->getStoreCommunity($this->getStore()->store_id);


    	$hasDesc = 0;
		$hasSns = 0;
		$hasPaymethod = 0;

		if($storeInfo->description){
			$hasDesc = 1;
		}

		if($storeSns->twitter || $storeSns->facebook){
			$hasSns = 1;
		}


    	return new ViewModel(array(
    			'scharge' => $storeInfo->scharge,
    			'name' => $this->getStore()->name,
    			'domail' => $this->getStore()->domain,
    			'public_status' => $this->getStore()->public_status,
    			'store_public_btn' => $public_status,
    			'store_desc_btn' => $storeInfo->description_btn,
    			'hasDesc' => $hasDesc ,
    			'hasSns' => $hasSns ,
    			'hasPaymethod' => $hasDesc ,
    	));
     }

     public function detailAction()
     {
     	$this->layout('layout/setup');

     	$request = $this->getRequest();
     	$view = new ViewModel;

     	$detail = $this->getStoreInfoTable()->getStoreInfo($this->getStore()->store_id);

     	if($request->isPost()){
			$inputDetail = $request->getPost('detail');
			if(strlen($inputDetail) > 0){
				$inputDetail = str_replace("#","&#35;",$inputDetail);
				$inputDetail = str_replace("&","&#38;",$inputDetail);
				$inputDetail = str_replace("<","&lt;",$inputDetail);
				$inputDetail = str_replace(">","&gt;",$inputDetail);
				$inputDetail = str_replace("(","&#40;",$inputDetail);
				$inputDetail = str_replace(")","&#41;",$inputDetail);
			}
			$detail->description = $inputDetail;

			$res = $this->getStoreInfoTable()->editStoreInfo($detail);
			if(!$res){
				// 変更なし。変更できなかった場合、どうする？
			}
	  	}

     	$view->detail = $detail;
     	return $view;
     }

     public function paymethodAction()
     {
     	$this->layout('layout/setup');
     }

     public function snsAction()
     {
     	$this->layout('layout/setup');
     	$request = $this->getRequest();

     	$sns = $this->getStoreCommunityTable()->getStoreCommunity($this->getStore()->store_id);

     	if( $request->isPost() ){
     		$sns->exchangeArray($request->getPost());
     		$sns->store_id = $this->getStore()->store_id;
     		$this->getStoreCommunityTable()->editStoreCommunity($sns);
      	}
     	$view = new ViewModel;
     	$view->sns = $sns;
     	return $view;
     }

     public function asctAction()
     {
		$this->layout('layout/setup');
     }

     /* Ajax */
     public function changeNameAction()
     {
     	$name = $_POST["store_name"];
     	if ( isset($name) ) {

     		if(strlen($name) >= 255  ){
     			$data = array("msg" => "ストアの名前は200文字までです。", "error" => "error");
     			echo  Json::encode($data);
     			exit;
     		}

     		if(strlen($name) > 0){
     			$name = str_replace("#","&#35;",$name);
     			$name = str_replace("&","&#38;",$name);
     			$name = str_replace("<","&lt;",$name);
     			$name = str_replace(">","&gt;",$name);
     			$name = str_replace("(","&#40;",$name);
     			$name = str_replace(")","&#41;",$name);
     		}

     		$this->getStore()->name = $name;
     		$res = $this->getStoreTable()->editStore($this->getStore());
     		if(!$res){
     			$data = array("msg" => "ng", "text" => $test ,"error" => "ok");
     		}
     		$data = array("msg" => "ok", "name" => $name,"error" => "");
     		echo  Json::encode($data);
     		exit;
     	}
     }

     /* Ajax */
     public function changePublicAction()
     {
     	$public = $this->getStore()->public_status;

     	if($public == 'Y') {
     		$public= 'N';
     	}else{
     		$public= 'Y';
     	}

     	$this->getStore()->public_status = $public;
     	$res = $this->getStoreTable()->editStore($this->getStore());
     	if(!$res){}

     	$data = array("msg" => "ok", "public" => $public , "error" => "");
     	echo  Json::encode($data);
		exit;
     }

     /* Ajax */
     public function schargeAction()
     {
     	if ( isset($_POST["scharge"]) ) {

     		if( $_POST["scharge"] != '' && !is_numeric($_POST["scharge"]) ){
     			$data = array("msg" => "数字のみ登録可能", "error" => "error");
     			echo  Json::encode($data);
     			exit;
     		}

     		$storeInfo = $this->getStoreInfoTable()->getStoreInfo($this->getStore()->store_id);
     		$storeInfo->scharge = $_POST["scharge"];
     		$res = $this->getStoreInfoTable()->editStoreInfo($storeInfo);

     		if(!$res){
     			$data = array("msg" => "ng", "error" => "ok");
     		}
     		$data = array("msg" => "ok", "error" => "");

     		echo  Json::encode($data);
     		exit;
     	}
     }

}
