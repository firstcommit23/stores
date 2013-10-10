<?php
namespace Setup\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import

class Products implements InputFilterAwareInterface
{

	public $id;
    public $order_id;
    public $name;
    public $variation_name;
    public $image_name;
    public $price;
    public $count;

    protected $inputFilter;

    public function exchangeArray($data)
    {
    //	var_dump($data);

        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->order_id  = (isset($data['order_id'])) ? $data['order_id'] : null;
        $this->name  = (isset($data['name'])) ? $data['name'] : null;
        $this->variation_name  = (isset($data['variation_name'])) ? $data['variation_name'] : null;
        $this->image_name  = (isset($data['image_name'])) ? $data['image_name'] : null;
        $this->price  = (isset($data['price'])) ? $data['price'] : null;
        $this->count  = (isset($data['count'])) ? $data['count'] : null;

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
