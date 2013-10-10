<?php
namespace Setup\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import

class StoreCommunity implements InputFilterAwareInterface
{

    public $store_id;
    public $facebook;
    public $twitter;
    public $homepage;


    protected $inputFilter;

    public function exchangeArray($data)
    {

        $this->store_id  = (isset($data['store_id'])) ? $data['store_id'] : null;
        $this->facebook  = (isset($data['facebook'])) ? $data['facebook'] : null;
        $this->twitter  = (isset($data['twitter'])) ? $data['twitter'] : null;
        $this->homepage  = (isset($data['homepage'])) ? $data['homepage'] : null;

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
        }
        return $this->inputFilter;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


}
