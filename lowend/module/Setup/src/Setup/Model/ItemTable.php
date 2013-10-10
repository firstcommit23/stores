<?php
namespace Setup\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Expression;

class ItemTable
{
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    //商品一覧表示のためselect
    public function fetchAll($page)
    {

    	//compose select
    	$dbSelect = $this->tableGateway->getSql()
    	->select()
    	->columns(array('id', 'item_no', 'img1','item_name','coast','stock','status'))
    	->where('13')
    	//->where('store_id')
    	->order('item_no ASC');


    	// use DbSelect Adapter by pass select object and DB Adapter
    	// DbSelect use COUNT() to get row count
    	$iteratorAdapter = new \Zend\Paginator\Adapter\DbSelect(
    		$dbSelect,
    		$this->tableGateway->getAdapter()
    	);

    	$paginator = new \Zend\Paginator\Paginator($iteratorAdapter);
    	$paginator->setCurrentPageNumber($page)
    	          ->setItemCountPerPage(10);


        return $paginator;

    }

    //商品一覧のsortの選択によってソート
    public function fetchSearch($page, $action, $searchValue)
    {

    	// compose select
        $sql = new Sql($this->tableGateway->adapter);
        $dbSelect = $sql->select();

        switch($action){
            case 'searchStr':
            $itemName = $searchValue;
           // var_dump($itemName);

            $dbSelect->from('item');
            $dbSelect->where(array('store_id' => 13, 'item_name' => $itemName));
            $dbSelect->order('item_no ASC');
            break;

            case 'category':

            $categoryId = $searchValue;


            $dbSelect->from('item');
            $dbSelect->where(array('store_id' => 13, 'categories_id' => $categoryId));
            $dbSelect->order('item_no ASC');
            break;

            case 'status':

            $itemStatus = $searchValue;

            $dbSelect->from('item');
            $dbSelect->where(array('store_id' => 13, 'status' => $itemStatus));
            $dbSelect->order('item_no ASC');
            break;

       }

       // use DbSelect Adapter by pass select object and DB Adapter
       // DbSelect use COUNT() to get row count
       $iteratorAdapter = new \Zend\Paginator\Adapter\DbSelect(
           $dbSelect,
           $this->tableGateway->getAdapter()
       );
       $paginator = new \Zend\Paginator\Paginator($iteratorAdapter);
       $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);

      return $paginator;

    }

     //商品編集の時
    public function getItem($id)
    {

        $id     = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row    = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    //商品登録する前、既存の商品番号にplus1する
    public function plusItemNo()
    {

    	$sql    = new Sql($this->tableGateway->adapter);
    	$update = $sql->update();
    	$update->table('item');
    	$update->set(array('item_no' => new Expression('item_no + 1')));

    	$statement = $sql->prepareStatementForSqlObject($update);

    	$update    = $statement->execute();

    	if(isset($update)){
    		return TRUE;
    	}


    }

    //商品登録
    public function insertItem($item)
    {
    	//var_dump($item);

        $data = array(
            //'store_id'  => stripslashes($item['store_id']),
            'store_id'              => '13',
        	//登録したものを一番上にするため
            'item_no'               => '1',
            'item_name'             => stripslashes($item['item_name']),
            'img1'                  => stripslashes($item['img1']),
        	'coast'                 => stripslashes($item['coast']),
        	'stock'                 => stripslashes($item['stock']),
            'status'                => stripslashes($item['status']),
        	'description'           => stripslashes($item['description']),
        	'item_status'           => stripslashes($item['item_status']),
      //  	'variation_falg'        => stripslashes($item['variation_falg']),
        	'tag'                   => stripslashes($item['status']),
        	'shop_field_category'   => stripslashes($item['shop_field_category']),
        	'shopping_field_status' => stripslashes($item['shopping_field_status'])
        );


       	try {
       		$var = $this->tableGateway->insert($data);
       		if(isset($var)){
       			return TRUE;
       		}
       	} catch (\Zend\Db\Adapter\Exception\InvalidQueryException $e) {
       		throw $e->getPrevious();
       	}


    }



    //商品編集
    public function updateItem($getPost)
    {
    	$data = array(
    		'item_name' => stripslashes($getPost['item_name']),
    		'img1'      => stripslashes($getPost['img1']),
    		'coast'     => stripslashes($getPost['coast']),
    		'stock'     => stripslashes($getPost['stock']),
    	);


    	try {
    		$var = $this->tableGateway->update($data,array('id' => $getPost['id']));
    		if(isset($var)){
    			return TRUE;
    		}
    	} catch (\Zend\Db\Adapter\Exception\InvalidQueryException $e) {
    		throw $e->getPrevious();
    	}


    }

    //商品削除
    public function deleteItem($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }



    //item_variations tableにデータをinsertする
    public function insertItemVariation($itemVariation)
    {

    	$variCount = count($itemVariation);

    	for($cnt=1; $cnt<=$variCount; $cnt++){

    	    $sql    = new Sql($this->tableGateway->adapter);
    	    $insert = $sql->insert();
    	    $insert->into('item_variations');
    	    $insert->columns(array('item_id','store_id','variation_name','total_stock'));

        	$insert->values(array(
    			'item_id'          => stripslashes($itemVariation[$cnt]['item_id']),
    			'store_id'         => stripslashes($itemVariation[$cnt]['store_id']),
    			'variation_name'   => stripslashes($itemVariation[$cnt]['variation_name']),
    			'total_stock'      => stripslashes($itemVariation[$cnt]['total_stock']),
    	    ));

    	    $statement = $sql->prepareStatementForSqlObject($insert);
    	    $insert    = $statement->execute();

    	}

    	return TRUE;


    }


    //categoryを取得する
    public function selectCategory($store_id)
    {

    	$sql    = new Sql($this->tableGateway->adapter);
        $select = $sql->select();
        $select->from('categories');
        $select->where(array('store_id' => $store_id));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results   = $statement->execute();

    	return $results;
    }

    //一番最近登録した商品のstore_idを取得する
    public function selectItemId($store_id)
    {
    	$sql    = new Sql($this->tableGateway->adapter);
        $select = $sql->select();
        $select->from('item');
        $select->where(array('store_id' => $store_id));
        $select->order('id DESC');

        $statement = $sql->prepareStatementForSqlObject($select);
        $results   = $statement->execute();

        $row     = $results->current();

        $item_id = $row['id'];

    	return $item_id;


    }

    //カテゴリリスト取得
    public function selectCategoryList($storeId)
    {

    	$sql    = new Sql($this->tableGateway->adapter);
    	$select = $sql->select();
    	$select->from('categories');
    	$select->where(array('store_id' => '13'));

    	$statement = $sql->prepareStatementForSqlObject($select);
    	$results   = $statement->execute();


    	return $results;


    }

    public function selectCategoryName($categoryId)
    {

    	$sql    = new Sql($this->tableGateway->adapter);
        $select = $sql->select();
        $select->from('categories');
        $select->where(array('id' => $categoryId,'store_id' => '13'));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results   = $statement->execute();

        $row = $results->current();

        $categoryName = $row['name'];

    	return $categoryName;


    }

    public function selectCategoryId($ajaxCategoryValue)
    {
    	$sql    = new Sql($this->tableGateway->adapter);
    	$select = $sql->select();
    	$select->from('categories');
    	$select->where(array('name' => $ajaxCategoryValue ,'store_id' => '13'));

    	$statement = $sql->prepareStatementForSqlObject($select);
    	$results   = $statement->execute();

    	$row = $results->current();

    	$categoryId = $row['id'];

    	return $categoryId;


    }

    public function insertCategory($category)
    {

    	$sql    = new Sql($this->tableGateway->adapter);
    	$insert = $sql->insert();
    	$insert->into('categories');
    	$insert->columns(array('store_id','name'));

    	$insert->values(array(
    			'store_id' => stripslashes($category['store_id']),
    			'name'     => stripslashes($category['categoryName'])
    	));

    	$statement = $sql->prepareStatementForSqlObject($insert);
    	$insert    = $statement->execute();


    }

    public function updateCategory($category)
    {


    	$sql    = new Sql($this->tableGateway->adapter);
    	$update = $sql->update();
    	$update->table('categories');
    	$update->set(array('name'=>$category['editCateName']));
    	$update->where(array('id'=>$category['categoryId'],'store_id'=>$category['store_id']));

    	$statement = $sql->prepareStatementForSqlObject($update);
    	$update    = $statement->execute();



    }

    public function  deleteCategory($deleteCategoryId,$store_id)
    {
    	$sql    = new Sql($this->tableGateway->adapter);
    	$delete = $sql->delete();
    	$delete->from('categories');
    	$delete->where(array('id'=>$deleteCategoryId , 'store_id'=>$store_id));

    	$statement = $sql->prepareStatementForSqlObject($delete);
    	$delete    = $statement->execute();



    }

    public function duplicatedCategory($ajaxCategoryValue)
    {

    	$sql    = new Sql($this->tableGateway->adapter);
    	$select = $sql->select();
    	$select->from('categories');
    	$select->where(array('name' => $ajaxCategoryValue,'store_id' => '13'));

    	$statement = $sql->prepareStatementForSqlObject($select);
    	$results   = $statement->execute();

    	if($results->count() >=1){
    		return 1;
    	}else{
    		return 0;
    	}


    }

    public function insertItemCategoryData($item_category)
    {

    	$sql    = new Sql($this->tableGateway->adapter);
    	$insert = $sql->insert();
    	$insert->into('categories');
    	$insert->columns(array('store_id','name'));

    	$insert->values(array(
    			'store_id' => stripslashes($category['store_id']),
    			'name'     => stripslashes($category['categoryName'])
    	));

    	$statement = $sql->prepareStatementForSqlObject($insert);
    	$insert    = $statement->execute();


    }

    //並び替えの時item_noを変更する
    public function updateItemNo($currentNo,$mNo)
    {

    	$sql    = new Sql($this->tableGateway->adapter);
    	$update = $sql->update();
    	$update->table('item');
    	$update->set(array('item_no' => new Expression( 'CASE WHEN item_no = ' . $currentNo . ' THEN ' . $mNo .
    			                                        ' WHEN item_no = ' . $mNo .    ' THEN ' . $currentNo .
    			                                        ' END'.
    			                                        ' WHERE store_id=13 AND item_no IN ( ' . $currentNo . ' , ' . $mNo.')'
    			)));


    	//var_dump($update->getSqlString());

    	$statement = $sql->prepareStatementForSqlObject($update);
    	$update    = $statement->execute();

    	if(isset($update)){
    		return TRUE;
    	}

    	/*
        //①押したbuttonのitem_noを-1してDBに登録
    	$sql    = new Sql($this->tableGateway->adapter);
    	$update = $sql->update();
    	$update->table('item');
    	$update->set(array('item_no'=>$mNo));
    	$update->where(array('store_id'=>13,'item_no'=>$currentNo));

    	$statement = $sql->prepareStatementForSqlObject($update);
    	$update    = $statement->execute();

    	//var_dump($update);
           //② ①が成功したら、元々あったitem_noに押したbuttonの番号を入れる
    	    if(isset($update)){

    		$sql    = new Sql($this->tableGateway->adapter);
    		$update = $sql->update();
    		$update->table('item');
    		$update->set(array('item_no'=>$currentNo));
    		$update->where(array('store_id'=>13,'item_no'=>$mNo));

    		$statement = $sql->prepareStatementForSqlObject($update);
    		$update    = $statement->execute();

            //③ ①・②が終わったらajaxで商品番号だけ変更した物に変わる？
    	} */
    }




}