<?php
namespace Setup\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter,
Zend\Db\ResultSet\ResultSet;

class StoreBankTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getStoreBank($store_id)
    {

    	$rowset = $this->tableGateway->select(array('store_id ' => $store_id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
    	return $row;
    }

    public function editStoreBank(StoreBank $storeBank)
    {
    	$data = array(
    			'store_id'		=> $storeBank->store_id,
    			'bank'			=> $storeBank->bank,
    			'bank_code'		=> $storeBank->bank_code,
    			'branch'		=> $storeBank->branch,
    			'branch_code'	=> $storeBank->branch_code,
    			'type'			=> $storeBank->type,
    			'account_name'  => $storeBank->account_name,
    			'account_no'	=> $storeBank->account_no,
    	);

    	$res = $this->tableGateway->update($data, array('store_id' => $storeBank->store_id));
    	return $res;
    }


}
