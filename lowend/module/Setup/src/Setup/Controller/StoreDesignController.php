<?php

namespace Setup\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Setup\Model\StoreStyle;

class StoreDesignController extends AbstractActionController
{

	/*
	 *  Store Table
	*/
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
	protected $storeStyleTable;
	public function getStoreStyleTable()
	{
		if (!$this->storeStyleTable) {
			$sm = $this->getServiceLocator();
			$this->storeStyleTable = $sm->get('Setup\Model\StoreStyleTable');
		}
		return $this->storeStyleTable;
	}

	protected $view;
	function getViewModel()
	{
		if (!$this->view) {
			$this->view = new ViewModel();
		}
		return $this->view;
	}

	/* Index */
    public function indexAction()
    {
    	$this->layout('layout/store_design');

    	$this->setStoreDesignDate();

    	$token =  base64_decode($_COOKIE['AUTH_TOKEN'] );
		$store_date = $this->getStoreTable()->getStore($token);
		$store_id = $store_date->store_id;

		// store style set
		$store_style= $this->getStoreStyleTable()->getStoreStyle($store_id);
		$this->getViewModel()->store = $store_style;

		// item List set
		if(true){
			$this->getViewModel()->itemList = $this->getSampleItemList();
		}else{
			// get Item List
		}

		//store title set
		$store_title = $this->getStoreTable()->getStore($token)->name;
		if($store_title == ''){
			$this->getViewModel()->title = '';
		}else{
			$this->getViewModel()->title = $store_title;
		}

		// store category set
    	return $this->getViewModel();
    }

    /* Save */
    public function excuteAction()
    {
    	$request = $this->getRequest();
    	if($request->isPost()){

    		$storeStyle = new StoreStyle();
    		$storeStyle->exchangeArray($request->getPost());

    		$storeStyle->background = str_replace("\"", "",$storeStyle->background);
    		$token =  base64_decode($_COOKIE['AUTH_TOKEN'] );
    		$store_date = $this->getStoreTable()->getStore($token);
    		$store_id = $store_date->store_id;
    		$storeStyle->store_id = $store_id;

    		$res= $this->getStoreStyleTable()->editStoreStyle($storeStyle);
    	}

    	return $this->redirect()->toRoute('store_design', array('action'=>'index'));
    	//return $this->redirect()->toRoute('setup', array('action'=>'index'));
    }

    /* Ajax */
    public function fileLogoUploadAction()
    {
    	$request = $this->getRequest();
    	if ($_FILES["LogoToUpload"]) {

    		$file = $_FILES["LogoToUpload"]["name"];
    		$uploaddir = __DIR__ . "/../../../../../public/upload/temp/";

    		$uploadfile = $uploaddir . $file;
    		if(!move_uploaded_file($_FILES["LogoToUpload"]["tmp_name"], $uploadfile)) {
    			unset($uploadfile);
    		}
    		list($iWidth, $iHeight) = getimagesize($uploadfile);
    		$data = array("msg" => "ok", "file_name" => $file ,"error" => "");

    		echo  Json::encode($data);
    		exit;
    	}
    }

    /* Ajax */
    public function fileUploadAction()
    {
     	if ($_FILES["fileToUpload"]) {
    		 $file = $_FILES["fileToUpload"]["name"];
    		$uploaddir = __DIR__ . "/../../../../../public/upload/temp/";

    		$uploadfile = $uploaddir . $file;
    		if(!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploadfile)) {
    			unset($uploadfile);
    		}
    		list($iWidth, $iHeight) = getimagesize($uploadfile);
     	  	$data = array("msg" => "ok", "file_name" => $file ,"error" => "");
    		echo  Json::encode($data);
    		exit;
    	}
	}

	/* Sampleアイテムリスト */
	private function getSampleItemList()
	{
		$sample = array();
		$sample[0] = array("img" => "/images/segun.jpg",
							"title" => "SAMPLE",
							"price" => "100,000");
		$sample[1] = array("img" => "/images/segun.jpg",
							"title" => "SAMPLE",
							"price" => "100,000");
		$sample[2] = array("img" => "/images/segun.jpg",
							"title" => "SAMPLE",
							"price" => "100,000");
		$sample[3] = array("img" => "/images/segun.jpg",
							"title" => "SAMPLE",
							"price" => "100,000");
		$sample[4] = array("img" => "/images/segun.jpg",
							"title" => "SAMPLE",
							"price" => "100,000");
		$sample[5] = array("img" => "/images/segun.jpg",
							"title" => "SAMPLE",
							"price" => "100,000");
		$sample[6] = array("img" => "/images/segun.jpg",
							"title" => "SAMPLE",
							"price" => "100,000");
		$sample[7] = array("img" => "/images/segun.jpg",
							"title" => "SAMPLE",
							"price" => "100,000");
		return $sample;
	}

	/* ストアデザインデーター */
	private function setStoreDesignDate()
	{

		$background_color_arr = array("#e51919", "#e5bc19", "#66b714", "#19bce5", "#1466b7", "#bc42bc", "#6b42bc", "#bc4241", "#bca442", "#669534", "#42a4bc", "#346696", "#a45aa4", "#7359a4",
				"#ff9393", "#ffe993", "#bdff7e", "#b7f0fe", "#7ebeff", "#e9a9e9", "#bea9e9", "#fbcfcf", "#fbf2cf", "#e0fbc5", "#cff2fb", "#c4e0fb", "#f2d8f2", "#e1d8f2",
				"#4b4545", "#4b4a45", "#393c36", "#454a4c", "#373a3c", "#4a464a", "#47464a", "#000000", "#333233", "#666666", "#808080", "#999999", "#cccccc", "#ffffff" );

		$layout_arr[] = array("img" => "https://stores.jp/images/button/btn_layout_1.gif",
				"className" => "layout_a");
		$layout_arr[] = array("img" => "https://stores.jp/images/button/btn_layout_2.gif",
				"className" => "layout_b");
		$layout_arr[] = array("img" => "https://stores.jp/images/button/btn_layout_3.gif",
				"className" => "layout_c");
		$layout_arr[] = array("img" => "https://stores.jp/images/button/btn_layout_4.gif",
				"className" => "layout_h");
		$layout_arr[] = array("img" => "https://stores.jp/images/button/btn_layout_5.gif",
				"className" => "layout_d");
		$layout_arr[] = array("img" => "https://stores.jp/images/button/btn_layout_6.gif",
				"className" => "layout_e");
		$layout_arr[] = array("img" => "https://stores.jp/images/button/btn_layout_7.gif",
				"className" => "layout_f");
		$layout_arr[] = array("img" => "https://stores.jp/images/button/btn_layout_8.gif",
				"className" => "layout_g");

		$backgound_img_arr = array("https://stores.jp/images/samples/bg/bg_1.gif",
				"https://stores.jp/images/samples/bg/bg_2.gif",
				"https://stores.jp/images/samples/bg/bg_3.gif",
				"https://stores.jp/images/samples/bg/bg_4.gif",
				"https://stores.jp/images/samples/bg/bg_5.gif",
				"https://stores.jp/images/samples/bg/bg_6.gif",
				"https://stores.jp/images/samples/bg/bg_7.gif",
				"https://stores.jp/images/samples/bg/bg_8.gif",
				"https://stores.jp/images/samples/bg/bg_9.gif",
				"https://stores.jp/images/samples/bg/bg_10.gif",
				"https://stores.jp/images/samples/bg/bg_11.gif",
				"https://stores.jp/images/samples/bg/bg_12.gif",
				"https://stores.jp/images/samples/bg/bg_13.gif",
				"https://stores.jp/images/samples/bg/bg_14.gif",
				"https://stores.jp/images/samples/bg/bg_15.gif",
				"https://stores.jp/images/samples/bg/bg_16.gif",
				"https://stores.jp/images/samples/bg/bg_17.gif",
				"https://stores.jp/images/samples/bg/bg_18.gif",
				"https://stores.jp/images/samples/bg/bg_19.gif",
				"https://stores.jp/images/samples/bg/bg_20.gif",
				"https://stores.jp/images/samples/bg/bg_21.gif",
				"https://stores.jp/images/samples/bg/bg_22.gif",
				"https://stores.jp/images/samples/bg/bg_23.gif",
				"https://stores.jp/images/samples/bg/bg_24.gif",
				"https://stores.jp/images/samples/bg/bg_25.gif",
				"https://stores.jp/images/samples/bg/bg_26.gif",
				"https://stores.jp/images/samples/bg/bg_27.gif",
				"https://stores.jp/images/samples/bg/bg_28.gif",
				"https://stores.jp/images/samples/bg/bg_29.gif",
				"https://stores.jp/images/samples/bg/bg_30.gif",
		);

		$this->getViewModel()->background_color_arr = $background_color_arr;
		$this->getViewModel()->layout_arr = $layout_arr;
		$this->getViewModel()->backgound_img_arr = $backgound_img_arr;
	}

}