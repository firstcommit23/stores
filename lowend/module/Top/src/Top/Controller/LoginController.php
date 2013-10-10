<?php
namespace Top\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Top\Model\Store;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Crypt\Password\Bcrypt;
use Zend\Crypt\BlockCipher;
use Zend\Crypt\Symmetric\Mcrypt;

class LoginController extends AbstractActionController
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

    public function indexAction()
    {
    	$this->layout('layout/top_all');
    	$this->checkAuthCookie();

    	$request = $this->getRequest();

		//ログイン処理
    	if ($request->getPost()->code == "check") {

    		$loginFlag = $this->getStoreTable()->isExistMember($request->getPost()->user_email,$request->getPost()->user_passwd);

   			switch($loginFlag){
   				// 通常
   				case 1:
   					$this->_create_token($request->getPost()->user_email);
   					return $this->redirect()->toRoute('setup', array('action'=>'index'));

   				// id false
   				case 2:
   					return new ViewModel(array(
   						'email' => $request->getPost()->user_email,
   						'err_msg' => 'ログイン情報がないです。'
   							));

   				//passwd false
   				case 3:
   					return new ViewModel(array(
	   					'email' => $request->getPost()->user_email,
	   					'err_msg' => 'ログイン情報がないです。',
   					));
   					break;
   			}

    		return new ViewModel(array(
    				'err_msg' => 'おかしいエラーが発生しました',
    		));
    	}
     }

    public function editPasswordAction(){
     	$this->layout('layout/top_all');
     	$this->checkAuthCookie();

     	$request = $this->getRequest();
     	$err_msg ='';

     	$bcrypt = new Bcrypt();
     	$securePass = $bcrypt->create($request->getPost()->edit_password);

     	$data = array(
            'email' => $request->getPost()->user_email,
            'password'  =>$securePass,
        );

     	$store = new Store();
     	$store->exchangeArray($data);

     	if($request->getPost()->edit_password != null){
     		$edit_password = $request->getPost()->edit_password;
     		$res = $this->getStoreTable()->editStore($store);
     		if(!$res){
     			return new ViewModel(array(
     					'msg' => 'err',
     			));
     		}
     		return new ViewModel(array(
     				'msg' => '変更できました',
     		));
     	}else{
     		return new ViewModel(array(
    				'msg' => 'ぬるです',
    		));
     	}
     }

    public function forgotPasswordAction()
    {
    	$this->layout('layout/top_all');
    	$this->checkAuthCookie();

    	$request   = $this->getRequest();

    	// parameter 存在ない
		if($request->getQuery('email') == null){
			return new ViewModel(array(
					'action' => '/top/login/sendMail',
					'submit_btn' => '転送',
					'title' => '登録時のメールアドレスを入力してください。'
			));

		// parameter 存在
		}else{
			$email =$request->getQuery()->email;
			$token =$request->getQuery()->token;

			$stl = 'secret';
			$hashMail = hash('md5',$email . $stl);
			if($token === $hashMail){
				return new ViewModel(array(
						'action' => '/top/login/editPassword',
						'title' => '変更するパスワードを入力してください。',
						'edit_pass' => 'true',
						'email' => $request->getQuery('email'),
						'token' => $request->getQuery('token'),
						'submit_btn' => '変更',
				));
			}else{
				return $this->redirect()->toRoute('top', array('action'=>'index'));
			}
		}
    }

    public function sendMailAction()
    {
    	$this->layout('layout/top_all');

    	$request      = $this->getRequest();
    	$email   = $request->getPost('user_email');
    	$stl = 'secret';
    	$hashMail = hash('md5',$email . $stl);

    	$mail = new Message();
    	$mail->setBody('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
このメールは、Estore.jp から配信されています
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
いつもEstore.jpをご利用いただき、ありがとうございます。


以下のURLから新しいパスワードを設定してください。

http://192.168.56.101/forgot_password?email='.$email . '&token=' . $hashMail);
    	$mail->setFrom('store@estore.co.jp', 'Estore');
    	$mail->addTo($email, 'Kim');
    	$mail->setSubject('[StoreBox]パスワード再発行');

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

    public function helpAction()
    {
    	$this->layout('layout/top_all');
    }

    private function _create_token($email)
    {

/*      	$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
    	$key = "e46c7932ece519f2d0ce983614d5dfc4";
    	$token = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $email, MCRYPT_MODE_ECB, $iv);
    //	$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
echo $token;
    	$valid_user = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, "e46c7932ece519f2d0ce983614d5dfc4", $token, MCRYPT_MODE_ECB, $iv);
    	print $valid_user;

  	echo "Encrypted text:1 \n";
    	$blockCipher = new BlockCipher(new Mcrypt(array('algo' => 'aes')));
    	echo "Encrypted text: 2\n";
    	$blockCipher->setKey('e46c7932ece519f2d0ce983614d5dfc4');
    	echo "Encrypted text:3 \n";
    	$result = $blockCipher->encrypt($email);
    	echo "Encrypted text:4 $result \n";

    	echo $blockCipher->decrypt($result); */


    //	$token = hash('md5', $email);
    	//$bcrypt = new Bcrypt();
    	//$token = $bcrypt->create($email);
    	//$key = "e46c7932ece519f2";
    	$token =  base64_encode($email);

    	setcookie('AUTH_TOKEN' , $token ,0,'','',false);
    }

    public function logoutAction()
    {
    	setcookie('AUTH_TOKEN' , '', 1 );
    	return $this->redirect()->toRoute('top', array('action'=>'index'));
    }

    public function checkAuthCookie()
    {
    	$token =$_COOKIE['AUTH_TOKEN'];
    	if($token == null) $token = '';

    	if ( !($token) ){
			// Login Cookie 存在する
			return;
    	}else{
    		// Login Cookie 存在しない
    		return $this->redirect()->toRoute('setup', array('action'=>'index'));
    	}
    }

}
