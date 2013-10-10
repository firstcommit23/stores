<?php
namespace Setup\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Setup\Model\Item;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Paginator\Paginator;
use Zend\Json\Json;

class ItemController extends AbstractActionController
{

	protected $itemTable;

	public function getItemTable()
	{

		if (!$this->itemTable) {
			$sm = $this->getServiceLocator();
			$this->itemTable = $sm->get('Setup\Model\ItemTable');
		}

		return $this->itemTable;
	}

	//商品一覧
    public function indexAction()
    {

        // 必要な変数を作る
        $view = new ViewModel;
        $item = array();
        $request = $this->getRequest();
        $page = (int) $this->params()->fromRoute('page', 1);

        // Requestがあれば（ソーロー）
        if($request->isPost()){
        	$searchValue = $request->getPost('searchValue');
        	//$category = $request->getPost('category');
            $action = $request->getPost('action');

            //var_dump($action);
            $item = $this->getItemTable()->fetchSearch($page, $action, $searchValue);

            // 各ソードーによって、検索値をアサインする
           if($action =='searchStr'){
               $view->searchStr = $searchValue;
           }else if($action == 'status'){
               $view->selectStatus = $searchValue;
           }else if($action =='category'){
               $view->selectCategory = $searchValue;
           }

           // Requestが無ければ（全体を見る）
           }else{
               $item = $this->getItemTable()->fetchAll($page);
           }

           //商品一覧のカテゴリセレクトにcategori list set
           $store_id=13;
           $categoryList = $this->getItemTable()->selectCategoryList($store_id);


           //Paging
           $pageView = $item->getPages();

           $view->item         = $item;
           $view->page         = $pageView;
           $view->categoryList = $categoryList;

           return $view;


    }

    //商品 err check
    public function itemRegistrationError($item)
    {
    	//$itemNameErr      = array();
    	//$itemCoastErr     = array();
    	//$itemImageListErr = array();
    	//$itemStockErr     = array();

    	//必須チェック
    	//商品名が空
    	if($item['item_name'] === NULL || $item['item_name'] === ''){
    		$itemNameErr = "商品名を入力してください";
    	}
    	//価額が空
    	if($item['coast'] === NULL || $item['coast'] === ''){
    		$itemCoastErr = "価格を入力してください";
    	}
    	//画像が空
    	/* if($item['itemImageList'] === NULL || $item['itemImageList'] === ''){
    		$itemImageListErr = "商品画像をアップロードしてください";
    	} */

    	//商品名maxチェック
    	if(strlen($item['item_name']) >=45){
    		$itemNameErr = "商品名は45文字以内で入力してください";
    	}

    	//価額maxチェック
    	if($item['coast'] >= 300000){
    		$itemCoastErr = "30万円以下に設定してください";
    	}

    	//紹介分maxチェック
    	//if(strlen($item['description']) >= 45 ){

    	//}

    	//在庫数字以外
    	if(preg_match("/[^0-9]/",$item['stock'])){
    		$itemStockErr = "在庫数を入力してください";
    	}



    	if(isset($itemNameErr) || isset($itemCoastErr) || isset($itemImageListErr) || isset($itemStockErr)){
    	    if(count($itemNameErr)>=1 || count($itemCoastErr)>=1 || count($itemImageListErr)>=1 || count($itemStockErr)>=1 ){
    		    $itemRegistErr['itemNameErr']       = $itemNameErr;
    		    $itemRegistErr['itemCoastErr']      = $itemCoastErr;
    		    $itemRegistErr['itemImageListErr']  = $itemImageListErr;
    		    $itemRegistErr['itemStockErr']      = $itemStockErr;

    		    return $itemRegistErr;

    	    }
    	}
    }

    //商品 variation err check
    public function itemVariRegistrationError($itemVariation)
    {

    	foreach($itemVariation as $no => $vari ){


    	    $itemVariationErr = array();

    	    //バリエーション名入力したいで、在庫数だけ入力
    	    if( ($itemVariation[$no]['variation_name'] === NULL || $itemVariation[$no]['variation_name'] === '') && isset($itemVariation[$no]['total_stock'])){
    		    $itemVariationErr[$no] = "種類を入力してください";
    	    }
    	    //在庫数入力したいで、バリエーション名だけ入力
    	    if( ($itemVariation[$no]['total_stock'] === NULL || $itemVariation[$no]['total_stock'] === '') && isset($itemVariation[$no]['variation_name'])){
    	    	$itemVariationErr[$no] = "在庫数を入力してください";
    	    }

    	    //バリエーションの在庫数字以外
    	    if(preg_match("/[^0-9]/",$itemVariation[$no]['total_stock'])){
        		$itemVariationErr[$no] = "在庫数を入力してください";
    	    }
    	    //バリエーション在庫数上限超えた場合
    	    if($itemVariation[$no]['total_stock'] >= 99){
    		    $itemVariationErr[$no] = "99個が上限です";

    	    }

    	}

    	//var_dump($itemVariationErr);
    	return $itemVariationErr;

    }


    //商品新規登録
    public function addAction()
    {

        $store_id='13';

    	//category list
    	$category = $this->getItemTable()->selectCategory($store_id);


    	$cate=array();
    	foreach($category as $value){
    		$cate[]=$value;
    	}

    	//shopping field categoryList(がら)
    	$shopCateList[0] = array(
    			'id'      => 1,
    			'name'   => "動物"
    			);
    	$shopCateList[1] = array(
    			'id'      => 2,
    			'name'   => "果物",
    	);
    	$shopCateList[2] = array(
    			'id'      => 3,
    			'name'   => "お菓子",
    	);

        $request = $this->getRequest();


        //requestがあったら以下の処理を行う
        if($request->isPost()){


    	    $item = array(
    	    		//'store_id'             => $store_id,
    	            //'categories_id'        => ,
    	            'item_no'                => $request->getPost()->item_no,
    		    	'item_name'              => $request->getPost()->item_name,
    	    		'coast'                  => $request->getPost()->coast,
    			    'img1'                   => $request->getPost()->img1,
    	    		'description'            => $request->getPost()->description,
    		     	'stock'                  => $request->getPost()->stock,
    	    		'status'                 => $request->getPost()->status,
    	    		'item_status'            => $request->getPost()->item_status,
    	    		'variation_falg'         => $request->getPost()->variation_falg,
    	    		'tag'                    => $request->getPost()->tag,
    	    		'shop_field_category'    => $request->getPost()->shoppingFieldCategory,
    	    		'shopping_field_status'  => $request->getPost()->shoppingFieldStatus
    	            );

    	    //insertする前、エラーチェック
    	    $itemRegistrationError = $this->itemRegistrationError($item);


    	    if($itemRegistrationError){

    	    	return new ViewModel(array(
    	    			'itemErr'      => $itemRegistrationError,
    	    			//カテゴリリストを表示するため
    	    			'cate'         => $cate,
    	    			'shopCateList' => $shopCateList
    	    	));

    	    }

    	    //DBに商品が一つ以上ある場合、insertする前、全商品の商品番号に+1する(一番最新商品番号を1にするため)
    	    //商品が一つ以上あるか確認必要
    	    $sussess = $this->getItemTable()->plusItemNo();

            //DBに商品データをinsert
    	    $var = $this->getItemTable()->insertItem($item);

    	    //itemテーブルにinsertが成功したら、item_category,variationテーブルにinsertする
    	    if($var == TRUE){
    	        //item_categoryテーブルにcheckboxで選択されたカテゴリidをinsertする
    	        $selectedCategory =  $request->getPost()->cate;
    	        $item_id = $this->getItemTable()->selectItemId($store_id);
    	        foreach($selectedCategory as $id=>$value){
    	            $item_category[] = array(
    	    	        	         'item_id'      => $item_id ,
    	    		                 'category_id'  => $value
                                     //'updated'    =>
    	    		                 );

    	        }
    	        //$var = $this->getItemTable()->insertItemCategoryData($item_category);
    	      //  var_dump($item_category);
    	      //  exit();

    	        //item variationの数
    	        $newVariCount = $this->request->getPost()->newVariCount;

    	        //insert後item_idをselect
    	        //$item_id = $this->getItemTable()->selectItemId($store_id);

    	        if(isset($newVariCount)){
    	            for($count = 1; $count <= $newVariCount; $count++){
    	    	        $vari           = 'vari'.$count;
    	    		    $variStock      =  'vari_stock'.$count;
    	    		    $variation_name = $this->request->getPost('vari' .$count);
    	    		    $total_stock    = $this->request->getPost('vari_stock' . $count);

    	    		    $itemVariation[$count] = array(
    	    		        'item_id'        => $item_id,
    	    			    'store_id'       => "13",
    	    			    'variation_name' => $variation_name,
    	    			    'total_stock'    => $total_stock
    	    		    );

    	    	    }

    	        }

    	        //variation err check
    	        $itemVariRegistrationError = $this->itemVariRegistrationError($itemVariation);

    	        //item ErrあるいはitemVariation Errがあったらtplにアサイン
    	        if($itemRegistrationError || $itemVariRegistrationError){

    	       	    return new ViewModel(array(
    	    		    'itemErr'      => $itemRegistrationError,
    	    		    'itemVariErr'  => $itemVariRegistrationError,
    	       	    	//カテゴリリストを表示するため
    	    		    'cate'         => $cate,
    	       		    'shopCateList' => $shopCateList
    	       	    ));

    	         }

    	        //item新規登録が成功したら、item_variations tableにinsertを行う
    	        $this->getItemTable()->insertItemVariation($itemVariation);

    	        //登録が成功したら商品一覧に移動
                $this->redirect()->toRoute('item');

    	        }else{
    		        return FALSE;
    	        }


            }

            return new ViewModel(array(
        		'cate' => $cate,
        		'shopCateList' => $shopCateList
            ));


    }



    //商品データ編集
    public function updateAction()
    {

    	$view = new ViewModel;

    	$id = (int) $this->params()->fromRoute('id', 0);

    	$store_id=13;
    	//category list
    	$category = $this->getItemTable()->selectCategory($store_id);

    	$cate=array();
    	foreach($category as $value){
    		$cate[]=$value;
    	}

    	$item = $this->getItemTable()->getItem($id);

    	$itemData = array(
    			   'id'                     => $id,
    	           //'store_id'             => $store_id,
    	           'item_name'              => $item->item_name,
    	           'img1'                   => $item->img1,
    	           'coast'                  => $item->coast,
    	           'stock'                  => $item->stock,
    	           'status'                 => $item->status,
    	           'description'            => $item->description,
    	           'item_status'            => $item->item_status,
    	           'variation_falg'         => $item->variation_falg,
    	           'tag'                    => $item->tag,
    	           'shop_field_category'    => $item->shop_field_category,
    	           'shopping_field_status'  => $item->shopping_field_status,

    	           );


    	$request = $this->getRequest();

    	if ($request->isPost()) {

    		$getPost = $request->getPost();

    		$this->getItemTable()->updateItem($getPost);

    		// Redirect to list of albums
    		return $this->redirect()->toRoute('item');
    	}

    	$view->itemData =$itemData;

    	return $view;
      /*   return new ViewModel(array(
        		'itemData' => $itemData,
        		'shopCateList' => $shopCateList
        )); */

    }

    //商品削除
    public function deleteAction()
    {

    	$deleteData = new ViewModel;

    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {

    		return $this->redirect()->toRoute('item');
    	}

    	$deleteData->id=$id;

    	$request = $this->getRequest();
    	if ($request->isPost()) {

    		$del = $request->getPost('del', 'No');

    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('id');
    			$this->getItemTable()->deleteItem($id);
    		}

    		// Redirect to list of albums
    		return $this->redirect()->toRoute('item');
    	}


    	return $deleteData;
    }

    public function insertCategoryAction($ajaxCategoryValue)
    {
    	$this->layout('layout/popup');

    	//$request = $this->getRequest();

    	//$categoryName = $request->getPost()->categoryName;

    	if(isset($ajaxNewCategoryValue)){


    		$category = array(
    			     	'store_id' => '13',
    				    'categoryName' => $ajaxCategoryValue
    				    );



    		$this->getItemTable()->insertCategory($category);

    	}

    }

    public function updateCategoryAction($ajaxCategoryValue,$editCategoryId)
    {
    	$this->layout('layout/popup');

    	$request = $this->getRequest();

    	$categoryId = (int) $this->params()->fromRoute('id', 0);

    	//select category name
    	$categoryName = $this->getItemTable()->selectCategoryName($categoryId);

    	//if($request->isPost()){
    		$category = array(
    				'store_id'     => 13,
    				'categoryId'   => $editCategoryId,
    				'editCateName' => $ajaxCategoryValue
    		);

    		$this->getItemTable()->updateCategory($category);

    		//$this->redirect()->toUrl('http://zf2-tutorial.localhost/item/add');
    	//}

    	return new ViewModel(array(
    			'id'           => $categoryId,
    			'categoryName' => $categoryName
    	));


    }

    public function deleteCategoryAction($deleteCategoryId)
    {

    	//$categoryId = (int) $this->params()->fromRoute('id', 0);


    	$store_id   = '13';

    	$this->getItemTable()->deleteCategory($deleteCategoryId,$store_id);

    	//$this->redirect()->toUrl('http://zf2-tutorial.localhost/item/add');


    }

    public  function insertCateAjaxAction()
    {
    	$ajaxCategoryValue = $_POST['newCate'];

    	//カテゴリ長さチェック
    	if(strlen($ajaxCategoryValue) > 20){
    		exit();
    	}

    	//カテゴリ重複チェック
    	$categoryName = $this->getItemTable()->duplicatedCategory($ajaxCategoryValue);
    	if(count($categoryName >1)){
    		exit();
    	}

    	$this->insertCategoryAction($ajaxCategoryValue);

    	$newCategoryId = $this->getItemTable()->selectCategoryId($_POST['newCate']);

    	$data    = array("msg" => "ok" ,"newCategory" => $ajaxCategoryValue , "newCategoryId" => $newCategoryId);

    	//echo Json::encode($data);
        exit();

    }


    public  function updateCateAjaxAction()
    {

    	$ajaxCategoryValue = $_POST['editCate'];

    	//カテゴリ長さチェック
    	if(strlen($ajaxCategoryValue) > 20){
    		exit();
    	}

    	//カテゴリ重複チェック
    	$categoryName = $this->getItemTable()->duplicatedCategory($ajaxCategoryValue);
    	if(count($categoryName >1)){
    		exit();
    	}

    	$editCategoryId = $_POST['cateId'];

    	$this->updateCategoryAction($ajaxCategoryValue,$editCategoryId);

    	$data   = array("msg" => "ok" ,"editCategory" => $ajaxCategoryValue , "editCategoryId" => $editCategoryId);

    	echo Json::encode($data);
    	exit();

    }

    public  function deleteCateAjaxAction()
    {

    	$deleteCategoryId = $_POST['cateId'];

    	$this->deleteCategoryAction($deleteCategoryId);

    	$data   = array("msg" => "ok" , "deleteCategoryId" => $deleteCategoryId);

    	echo Json::encode($data);
    	exit();

    }

    public function changeTableRowAction()
    {

    	//$flag      = $_POST['flag'];
    	$currentNo = $_POST['currentNo'];
    	$mNo       = $currentNo-1;

    	//$currentNo = $_POST['downNo'];

    	$var = $this->getItemTable()->updateItemNo($currentNo,$mNo);

    	if($var === TRUE){


    	    $data   = array("msg" => "ok" , "newNo" => $mNo,"changeNo" => $currentNo);

    	    echo Json::encode($data);
    	    exit();
    	}
    }

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

}