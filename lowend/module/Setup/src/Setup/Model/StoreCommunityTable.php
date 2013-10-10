<?php
namespace Setup\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter,
Zend\Db\ResultSet\ResultSet;

class StoreCommunityTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getStoreCommunity($store_id)
    {
    	$rowset = $this->tableGateway->select(array('store_id ' => $store_id));
    	$row = $rowset->current();
    	if (!$row) {
    		return new StoreCommunity();
    		//throw new \Exception("Could not find row $id");
    	}
    	return $row;
    }

    public function editStoreCommunity(StoreCommunity $storeCommunity)
    {
    	$data = array(
    			'twitter'  => $storeCommunity->twitter,
    			'facebook'  => $storeCommunity->facebook,
    			'store_id'  => $storeCommunity->store_id,
    	);

    	$hasRow = $this->tableGateway->select(array('store_id ' => $storeCommunity->store_id))->count();

    	if($hasRow){
    		$res = $this->tableGateway->update($data, array('store_id' => $storeCommunity->store_id));
    	}else{
    		$res = $this->tableGateway->insert($data);
    	}

    	return;
    }


}
