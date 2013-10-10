<?php
namespace Setup\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import

class StoreBank implements InputFilterAwareInterface
{

    public $store_id;
    public $bank;
    public $bank_code;
    public $branch;
    public $branch_code;
    public $type;
    public $account_name;
    public $account_no;

    public function exchangeArray($data)
    {
        $this->store_id  = (isset($data['store_id'])) ? $data['store_id'] : null;
        $this->bank  = (isset($data['bank'])) ? $data['bank'] : null;
        $this->bank_code  = (isset($data['bank_code'])) ? $data['bank_code'] : null;
        $this->branch  = (isset($data['branch'])) ? $data['branch'] : null;
        $this->branch_code  = (isset($data['branch_code'])) ? $data['branch_code'] : null;
        $this->type  = (isset($data['type'])) ? $data['type'] : null;
        $this->account_name  = (isset($data['account_name'])) ? $data['account_name'] : null;
        $this->account_no  = (isset($data['account_no'])) ? $data['account_no'] : null;
    }

    // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


}
