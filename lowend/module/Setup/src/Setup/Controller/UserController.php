<?php

namespace Setup\Controller;

use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Top\Model\Store;
use Setup\Model\StoreBank;

class UserController extends AbstractActionController
{
	protected $store;
	public function getStore()
	{
		if(!$this->store) {
			$token =  base64_decode($_COOKIE['AUTH_TOKEN'] );
			$this->store = $this->getStoreTable()->getStore($token);
		}
		return $this->store;
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

	protected $storeBankTable;

	public function getStoreBankTable()
	{
		if (!$this->storeBankTable) {
			$sm = $this->getServiceLocator();
			$this->storeBankTable = $sm->get('Setup\Model\StoreBankTable');
		}
		return $this->storeBankTable;
	}

	protected $storeTable;

	public function getStoreTable()
	{
		if (!$this->storeTable) {
			$sm = $this->getServiceLocator();
			$this->storeTable = $sm->get('Top\Model\StoreTable');
		}
		return $this->storeTable;
	}

    public function indexAction()
    {
    	$this->layout('layout/setup');
    	$storeInfo = $this->getStoreInfoTable()->getStoreInfo($this->getStore()->store_id);
    	return new ViewModel(array(
    			'mailmag_flag' => $storeInfo->mailmag_flag,
    			'email' => $this->getStore()->email,
    	));
    }

    /* LoginEmail変更用 SendMail() */
    public function sendMailAction(){
    	$this->layout('layout/setup');
    	$request = $this->getRequest();

    	$email   = $request->getPost('user_email');

    	if(! preg_match("/[a-zA-Z0-9_-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $email) > 0)
    	{


    		return new ViewModel(array(
    				'err_msg' => "Eメールが正しくないです。",

    		));
    	}

    	$stl = 'secret';
    	$hashMail = hash('md5',$email . $stl);

    	$mail = new Message();
    	$mail->setBody('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
このメールは、Estore.jp から配信されています
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
いつもEstore.jpをご利用いただき、ありがとうございます。


以下のURLから新しいパスワードを設定してください。

http://192.168.56.101/user/email?email='.$email . '&token=' . $hashMail. '&be=' . $this->getStore()->email  );
    	$mail->setFrom('store@estore.co.jp', 'Estore');
    	$mail->addTo($email, 'Kim');
    	$mail->setSubject('[StoreBox]ログインEmail変更');

    	$transport = new SmtpTransport();
    	$options   = new SmtpOptions(array(
    			'name' => 'low-end.sssestore',
    			'host' => '192.168.56.101',
    			'connection_class'  => 'smtp',
    			'connection_config' => array(
    					'username' => 'kim',
    					'password' => 'bkTytMxz',
    			),
    			'port' => 25,
    	));
    	$transport->setOptions($options);
    	$transport->send($mail);
    }

    public function emailAction()
    {
    	$this->layout('layout/setup');
    	$request   = $this->getRequest();

    	// parameter 存在ない
    	if($request->getQuery('email') == null){
    		return new ViewModel(array(
    				'title' => '不正なアクセスです'
    		));

    	// parameter 存在
    	}else{
    		$email =$request->getQuery()->email;
    		$token =$request->getQuery()->token;
    		$be =$request->getQuery()->be;

    		$stl = 'secret';
    		$hashMail = hash('md5', $email . $stl);
    		if($token === $hashMail){
    			$store_date = $this->getStoreTable()->getStore($be);
				$store_date->email = $email;

				$res = $this->getStoreTable()->editEmail($store_date, $be);

				$token =  base64_encode($email);

				setcookie('AUTH_TOKEN' , $token ,0,'','',false);

//Sign Up Table Change

    			return new ViewModel(array(
    					'state' => 'sucees',
    			));
    		}else{
    			return new ViewModel(array(
    			'err_msg' => '不正なアクセスです'
    	));
    		}
    	}

    	return new ViewModel(array(
    			'err_msg' => '不正なアクセスです'
    	));
    }

    /* Password 変更Action */
    public function passwordAction()
    {
    	$this->layout('layout/setup');
    	$request = $this->getRequest();

    	// Requestがあれば
    	if($request->isPost()){
    		// input data 取得
			$curPw = $request->getPost('cur_pw');
			$editPw = $request->getPost('edit_pw');

			$bcrypt = new Bcrypt();
			//暗号化された現在のパスワードの
			$securePass = $this->getStore()->password;
			//パスワードが一致すれば
			if ($bcrypt->verify($curPw, $securePass)) {
				$this->getStore()->password = $bcrypt->create($editPw);

				$res = $this->getStoreTable()->editStore($this->getStore());
				if(!$res){
					return new ViewModel(array(
							'msg' => 'err',
					));
				}

				return new ViewModel(array(
						'success' => 'true',
				));

			}else{

				return new ViewModel(array(
						'msg' => 'パスワードが一致しません。',
				));
			}
    	}
    }

    /* Password 確認Action */
    public function passwordValidAction()
    {
    	/*
    	remote: {type: "post", url:"/user/passwordValid"}

    	remote: "パスワードが一致しません。",

    	*/
    	$request = $this->getRequest();

    	// Requestがあれば
    	if($request->isPost()){
    		// input data 取得
    		$curPw = $request->getPost('cur_pw');

    		$bcrypt = new Bcrypt();
    		//暗号化された現在のパスワードの
    		$securePass = $this->getStore()->password;
    		//パスワードが一致すれば
    		if ($bcrypt->verify($curPw, $securePass)) {
    			$this->getStore()->password = $bcrypt->create($editPw);

    			echo 'true';
    			exit;

    		}else{

    			echo 'false';
    			exit;
    		}
    	}
    	exit;
    }


    public function mailMagazineAction()
    {
    	$this->layout('layout/setup');
    	$request = $this->getRequest();

    	if($request->isPost()){
    		$mail_addr= $request->getPost('mail_addr');

    		$data = array(
    			'mail'	=> $mail_addr,
    		);
    		$store = new Store();
    		$store->exchangeArray($data);
    		$res = $this->getStoreTable()->editStore($store);
    		if(!$res){}
    	}
    }

    public function bankAction()
    {
    	$this->layout('layout/setup');

    	$request = $this->getRequest();
    	$storeBank = $this->getStoreBankTable()->getStoreBank($this->getStore()->store_id);

    	if( $request->isPost() ){

    		$storeBank->exchangeArray( $request->getPost() );
    		$storeBank->store_id = $this->getStore()->store_id;
    		$res = $this->getStoreBankTable()->editStoreBank($storeBank);
    		if(!$res){}

    	}

    	return new ViewModel(array(
    			'store_bank' => $storeBank,
    	));
    }

    public function selectBankAction()
    {
    	$this->layout('layout/store_design');
    }

    public function withdrawalAction()
    {
		$this->getStore()->status = "N";
		$this->getStoreTable()->editStore( $this->getStore() );
		setcookie('AUTH_TOKEN' , '' );
		//Cookie
		return $this->redirect()->toRoute('top', array('action'=>'index'));
    }


    /* Ajax */
    public function changeMailmagAction()
    {
    	$storeInfo = $this->getStoreInfoTable()->getStoreInfo($this->getStore()->store_id);
    	$mailmag_flag = $storeInfo->mailmag_flag;

    	if($mailmag_flag == 'Y') {
    		$mailmag_flag= 'N';
    	}else{
    		$mailmag_flag= 'Y';
    	}

    	$storeInfo->mailmag_flag = $mailmag_flag;
    	$res = $this->getStoreInfoTable()->editStoreInfo($storeInfo);
    	if(!$res){}

    	$data = array("msg" => "ok", "mailmag_flag" => $mailmag_flag , "error" => "");
    	echo  Json::encode($data);
    	exit;
    }

}
