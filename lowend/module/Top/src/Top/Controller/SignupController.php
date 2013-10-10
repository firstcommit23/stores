<?php
namespace Top\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Top\Model\Signup;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Sql\Sql;


class SignupController extends AbstractActionController
{
	protected $signupTable;

	public function indexAction()
	{
		$request      = $this->getRequest();

		//postでもらったらSignupErrorActionに行ってチェック
		if($request->isPost()){
			$signupErr = $this->SignupError();
			 if(isset($signupErr)){
			 	return $signupErr;
			}else{
                //Errがなかったら以下の処理を行う
				//insert  err処理
				$this->insertSignup();
				//send mail err処理
				$this->sendSignupMail();
			}
		}

	}

	public function getSignupTable()
	{
		if (!$this->signupTable) {
			$sm = $this->getServiceLocator();
			$this->signupTable = $sm->get('Top\Model\SignupTable');
		}

		return $this->signupTable;
	}


	//エラーチェック
	public function SignupError()
	{

		//$smarty = new ViewModel;
		$signupErr=array();

		$request      = $this->getRequest();
		$domain   = $request->getPost('domain');
		$mail_address = $request->getPost('email');

		$password     = $request->getPost('password');
		$url_ret      = 0;
		$mail_ret     = 0;

	    $urlErr=array();
	    $mailErr=array();
	    $passwordErr=array();


	    //ERR
		if($domain === NULL || $domain === ''){
			$urlErr[]="・storeのurlを入力してください。";
		}
		if(strlen($domain) >= 20 || preg_match("/[^a-zA-Z0-9\-_]/",$domain)){
			$urlErr[]="・urlは20文字以内の英数字で入力してください。";
		}

		if($mail_address === NULL || $mail_address === ''){
			$mailErr[]="・mail addressを入力してください。";
		}
	  	/*  if(strlen($mail_address) >= 20 || preg_match("/[^a-zA-Z0-9\-_-@]/",$mail_address))  {
			$mailErr[]="・mail addressは20文字以内の英数字で入力してください。";
		} */

		if($password === NULL || $password === ''){
			$passwordErr[]="・passwordを入力してください。";
		}
		if(strlen($password) >= 20 || preg_match("/[^a-zA-Z0-9\-_]/",$password)){
			$passwordErr[]="・passwordは20文字以内の英数字で入力してください。";
		}


		//url重複チェック
		//$url_ret = $this->getSignupTable()->isDomainDuplicated($domain);

		//mail address重複チェック
		//$mail_ret = $this->getSignupTable()->isMailDuplicated($mail_address);


		if($url_ret >=1 ){
			$urlErr[]="・そのURLは既に使用されています。";
		}

		if($mail_ret >=1 ){
			$mailErr[]="・そのmail addressは既に使用されています。";
		}

		if(count($urlErr)>=1 || count($mailErr)>=1 || count($passwordErr)>=1){

			$signupErr['urlErr']=$urlErr;
			$signupErr['mailErr']=$mailErr;
			$signupErr['passwordErr']=$passwordErr;

			return $signupErr;

		}


	}

	//メール送信
	public function sendSignupMail()
	{
		//入力チェックと重複チェックをしてから以下
        //長さ、半角英数字以外はエラー

		$request      = $this->getRequest();
		$domain       = base64_encode($request->getPost('domain'));
		$mail_address = $request->getPost('email');
		$hash_mail_address = base64_encode($request->getPost('email'));

		$mail = new Message();
		$mail->setBody('http://zf2-tutorial.localhost/access?code='.$domain.'&email='.$hash_mail_address);
		$mail->setFrom('jeong@estore.co.jp', 'Estore');
		$mail->addTo($mail_address, 'jeong');
		$mail->setSubject('登録ありがとうございます！');
		// echo $mail->toString();

		//return;
		$transport = new SmtpTransport();
		$options   = new SmtpOptions(array(
				'name' => 'zf2-tutorial.localhost',
				'host' => '192.168.56.101',
				'connection_class'  => 'smtp',
				'connection_config' => array(
						'username' => 'jeong',
						'password' => 'ss9041',
				),
				'port' => 25,
		));
		$transport->setOptions($options);
		$transport->send($mail);

		return TRUE;

	}

    //sign up DBにデータを入れる
    public function insertSignup()
    {

    	$request = $this->getRequest();

    	$bcrypt = new Bcrypt();
    	$signup = array(
    			'domain'   => $request->getPost()->domain,
    			'email'    => $request->getPost()->email,
    			'password' => $bcrypt->create($request->getPost()->password)
    	        );



    	$var = $this->getSignupTable()->insertSignup($signup);

    	if($var === TRUE){
            // Redirect to list of success
            return $this->redirect()->toUrl('success');
    	}else{
    		return FALSE;
    	}

    }

    //メールに送信したurlにアクセスした時、判定
    public function AccessAction()
    {

    	//urlからdomainを取得
    	$request = $this->getRequest();
    	$code    = base64_decode($request->getQuery('code'));
    	$email    = base64_decode($request->getQuery('email'));

    	$signupData = $this->getSignupTable()->selectSignup($code);

        if($signupData['registry_status'] === 'N'){

        	//アクセスしたurlのdomainあるいはemailがstoreテーブルに存在するか確認
        	$existDomain = $this->getSignupTable()->existDomain($code);
        	$existEmail  = $this->getSignupTable()->existEmail($email);

           	if($existDomain == '1' || $existEmail == '1'){
        		$this->badAccessAction();
        	}else{

        	    //sign_up no status => Y
                //$this->getSignupTable()->updateStatus($code);

           	    //storeテーブルにデータをインサート
           	    //$this->getSignupTable()->insertStore($signupData);

    	        return new ViewModel(array(
    	            'flag' => "ok"
    	        ));

        	}

        }else{
    	    $this->badAccessAction();
        }


    }

    //sign_upが成功したら成功画面に移動する
    public function successAction()
    {
    	$smarty = new ViewModel;
    	return $smarty;

    }

    //同じurlに2回目以上:エラー画面(status=Yとか正しくないurlの場合)
    public function badAccessAction()
    {
      	 return new ViewModel(array(
    	     'flag' => "bad"
    	 ));

    }



}