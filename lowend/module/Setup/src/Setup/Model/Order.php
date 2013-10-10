<?php
namespace Setup\Model;

class Order
{
	public $id;
    public $store_id;
    public $scharge;
    public $fee;
    public $total;
    public $payment;
    public $state;
    public $created;
    public $updated;
    public $settlement_id;
    public $comment;

    public function exchangeArray($data)
    {

        $this->id 			= (isset($data['id'])) ? $data['id'] : null;
        $this->store_id  	= (isset($data['store_id'])) ? $data['store_id'] : null;
        $this->scharge 		= (isset($data['scharge'])) ? $data['scharge'] : null;
        $this->fee  		= (isset($data['fee'])) ? $data['fee'] : null;
        $this->total		= (isset($data['total'])) ? $data['total'] : null;
        $this->payment		= (isset($data['payment'])) ? $data['payment'] : null;
        $this->state		= (isset($data['state'])) ? $data['state'] : null;
        $this->created		= (isset($data['created'])) ? $data['created'] : null;
        $this->updated		= (isset($data['updated'])) ? $data['updated'] : null;
        $this->settlement_id= (isset($data['settlement_id'])) ? $data['settlement_id'] : null;
        $this->comment		= (isset($data['comment'])) ? $data['comment'] : null;

    }
}
