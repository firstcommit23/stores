<?php
namespace Setup\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter,
Zend\Db\ResultSet\ResultSet;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Sql\Where;

class OrderTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


    public function fetchAll($page)
    {

    	$sql = new Sql($this->tableGateway->adapter);
    	$dbSelect = $sql->select();
    	$dbSelect->from(array('ord' => 'orders'));
    	$dbSelect->where(array('store_id' => 3));

    	$iteratorAdapter = new \Zend\Paginator\Adapter\DbSelect(
    			$dbSelect,
    			$this->tableGateway->getAdapter()
    	);
    	$paginator = new \Zend\Paginator\Paginator($iteratorAdapter);
    	$paginator->setCurrentPageNumber($page)
    	->setItemCountPerPage(10);

    	return $paginator;
    }

    public function fetchSearch($page, $action, $value)
    {
    	// compose select
    	$sql = new Sql($this->tableGateway->adapter);
    	$dbSelect = $sql->select();

    	switch($action){
    		case 'order_date':
				$dayValue = $value . "%";

    			$dbSelect->from(array('ord' => 'orders'));
    			//$dbSelect->where($spec);
    			$dbSelect->where(array('store_id' => 3, 'created LIKE ?' => $dayValue));
    			break;

    		case 'searchStr':

    			$strValue = "%" . $value . "%";
    			$dbSelect->from(array('ord' => 'orders'));
    			$dbSelect->where(array('name  LIKE ?' => $strValue ));
    			$dbSelect->where(array('store_id' => 3));
    			$dbSelect->join(array('p' => 'order_item'),     // join table with alias
    					'ord.id = p.order_id');
    			$dbSelect->group('p.order_id');
    			break;

    		case 'state':
    			$dbSelect->from(array('ord' => 'orders'));
    			$dbSelect->where(array('store_id' => 3, $action => $value ));
/*     			$dbSelect->join(array('item' => 'products'),     // join table with alias
    					'ord.order_id = item.order_id');
    			$dbSelect->group('ord.order_id'); */
    			break;

    	}

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


    public function excuteState($store_id, $order_id, $status)
    {
/* 	   	$data = array(
	   				'state'  => $status,
    		);
   		$res = $this->tableGateway->update($data, array('stores_id' => $stores_id, 'order_id'  => $order_id ));
 */

    	$sql = new Sql($this->tableGateway->adapter);
    	$update = $sql->update();

    	$update->table('orders');
    	$update->where(array('store_id' => $store_id, 'id' => $order_id));
    	$update->set(array('state' => $status));


   		$statement = $sql->prepareStatementForSqlObject($update);

  //  	$statement = $update->prepareStatement($update);
    	$res = $statement->execute();

   		return $res;
    }


    public function getOrder($store_id, $order_id)
    {
    	$sql = new Sql($this->tableGateway->adapter);
    	$select = $sql->select();

    	$select->from(array('ord' => 'orders'));
    	$select->where(array('store_id' => $store_id, 'ord.id' => $order_id));
    	$select->join(array('pur' => 'purchaser'),     // join table with alias
    			'ord.id = pur.order_id');

    	$statement = $sql->prepareStatementForSqlObject($select);

    	$result = $statement->execute();

    	$row = $result->current();
    	return $row;


    }

    /*
    public function isExistMember($email, $passwd)
    {

    	$isIdCheckFlag = $this->isExistMemberEmail($email);
    	if(!$isIdCheckFlag) return 2;

    	$bcrypt = new Bcrypt();
    	$securePass = $this->getStore($email)->password;
    	if ($bcrypt->verify($passwd, $securePass)) {
    		return 1;
    	}else{
    		return 3;
    	}
    }

    public function isExistMemberEmail($email)
    {
    	try{
    		$sql = new Sql($this->tableGateway->adapter);
    		$select = $sql->select();
    		$select->from('store');
    		$select->where(array('email' =>  $email));

    		$statement = $sql->prepareStatementForSqlObject($select);
    		$result = $statement->execute();
    	}catch(Exception $e){
    		print "db err";
    	}

    	$resultSet = new ResultSet;
    	$resultSet->initialize($result);

    	if ($result->count()) {
    		return 1;
    	}
    	return 0;
    } */
}
