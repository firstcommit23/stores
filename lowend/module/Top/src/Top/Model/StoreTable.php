<?php
namespace Top\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter,
Zend\Db\ResultSet\ResultSet;
use Zend\Crypt\Password\Bcrypt;

class StoreTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
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


    public function getStore($email)
    {

    	$rowset = $this->tableGateway->select(array('email' => $email));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
    	return $row;
    }


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
    }
}
