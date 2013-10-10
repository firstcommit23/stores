<?php
namespace Top\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;


class SignupTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
    	 $this->tableGateway = $tableGateway;
    }

    //domain重複チェック
    public function isDomainDuplicated($domain)
    {

    	$sql = new Sql($this->tableGateway->adapter);
    	$select->from('sign_up');
    	$select->where(array('domain' =>  $domain));


    	$statement = $sql->prepareStatementForSqlObject($select);
    	$result = $statement->execute();

    	// build result set
    	$resultSet = new ResultSet;
    	$resultSet->initialize($result);

    	if ($result->count()) {
    		return 1;
    	}else{
    		return 0;
    	}

    	return TRUE;

    }
    //mail重複チェック
    public function isMailDuplicated($mail_address)
    {

    	$sql = new Sql($this->tableGateway->adapter);
    	$select = $sql->select();
    	$select->from('sign_up');
    	$select->where(array('email' =>  $mail_address));


    	$statement = $sql->prepareStatementForSqlObject($select);
    	$result = $statement->execute();

    	// build result set
    	$resultSet = new ResultSet;
    	$resultSet->initialize($result);


    	if ($result->count()) {
    		return 1;
    	}else{
    		return 0;
    	}

    }

    public function insertSignup($signup)
    {

        $data = array(
            'domain'     => $signup['domain'],
            'email'      => $signup['email'],
        	'password'   => $signup['password']
        );

        try {
        		$var = $this->tableGateway->insert($signup);
        		if(isset($var)){
        		    return TRUE;
        		}

        }catch (\Zend\Db\Adapter\Exception\InvalidQueryException $e) {
        		throw $e->getPrevious();
        	}

    }

    public function selectSignup($code)
    {

    	$sql    = new Sql($this->tableGateway->adapter);
    	$select = $sql->select();
    	$select->from('sign_up');
    	$select->where(array('domain' =>  $code));

    	$statement = $sql->prepareStatementForSqlObject($select);
    	$result    = $statement->execute();

    	$row = $result->current();

    	// build result set
    	$resultSet = new ResultSet;
    	$resultSet->initialize($result);



    	return $row;

    }

    //sign_up tbleのregistry_statusをYに変更する
    public function updateStatus($code)
    {

    	$data = array(
    		'registry_status' => 'Y'
    	);

    	$this->tableGateway->update($data, array('domain' => $code));

    	return TRUE;

    }

    //exit domain in store table
    public function existDomain($code)
    {

        $sql = new Sql($this->tableGateway->adapter);
    	$select = $sql->select();
    	$select->from('store');
    	$select->where(array('domain' =>  $code));


    	$statement = $sql->prepareStatementForSqlObject($select);
    	$result = $statement->execute();

    	// build result set
    	$resultSet = new ResultSet;
    	$resultSet->initialize($result);

    	if ($result->count()) {
    		return 1;
    	}else{
    		return 0;
    	}

    }

    //exit email in store table
    public function existEmail($email)
    {

    	$sql = new Sql($this->tableGateway->adapter);
    	$select = $sql->select();
    	$select->from('store');
    	$select->where(array('email' =>  $email));


    	$statement = $sql->prepareStatementForSqlObject($select);
    	$result = $statement->execute();

    	// build result set
    	$resultSet = new ResultSet;
    	$resultSet->initialize($result);

    	if ($result->count()) {
    		return 1;
    	}else{
    		return 0;
    	}

    }

    //store tableにデータをinsertする
    public function insertStore($signupData)
    {

    	$sql = new Sql($this->tableGateway->adapter);
    	$insert = $sql->insert();
    	$insert->into('store');
    	$insert->columns(array('domain','email','password'));

    	$insert->values(array(
    			'domain'     => stripslashes($signupData['domain']),
    			'email'      => stripslashes($signupData['email']),
    			'password'   => stripslashes($signupData['password']),
    	));

    	$statement = $sql->prepareStatementForSqlObject($insert);
    	$insert = $statement->execute();


    	return TRUE;



    }


}