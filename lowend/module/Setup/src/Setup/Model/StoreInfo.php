<?php
namespace Setup\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import

class StoreInfo implements InputFilterAwareInterface
{

    public $store_id;
    public $scharge;
    public $description;
    public $description_btn;
    public $mailmag_flag;

    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->store_id  = (isset($data['store_id'])) ? $data['store_id'] : null;
        $this->scharge  = (isset($data['scharge'])) ? $data['scharge'] : null;
        $this->description  = (isset($data['description'])) ? $data['description'] : null;
        $this->mailmag_flag  = (isset($data['mailmag_flag'])) ? $data['mailmag_flag'] : null;

        if(isset($data['description'])){
        	$this->description = $data['description'];
        	$this->description_btn = '編集2';
        }else{
        	$this->description = null;
        	$this->description_btn = '登録2';
        }
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
