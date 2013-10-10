<?php
namespace Setup\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter,
Zend\Db\ResultSet\ResultSet;
use Zend\Crypt\Password\Bcrypt;

class ProductTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
/*
    // Artist 順で Sort
    public function fetchAll($page)
    {
    	// compose select
    	$dbSelect = $this->tableGateway->getSql()
    	->select()
    	->columns(array('order_id', 'order_date', 'purchaser_name', 'total', 'payment', 'state'));
//    	->where(array('order_id' =>  $email));
//    	->columns(array('order_id', 'order_date', 'purchaser_name', 'total', 'payment', 'state'));
    //	->where(array('store_id' => 2))
 //   	->order(array('ASC order_id'));


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

 public function editStore(Store $store)
    {
	   	$data = array(
    				'email'  => $store->email,
    				'password'  => $store->password,
    		);
   		$res = $this->tableGateway->update($data, array('email' => $store->email));
		return $res;
    }
*/

    public function getProduct( $order_id)
    {

    	$rowset = $this->tableGateway->select(array('order_id' => $order_id));
    //	$row = $rowset->current();
    	if (!$rowset) {
    		throw new \Exception("Could not find row $id");
    	}

    	return $rowset;
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
