<?php
namespace Top\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import

class Store implements InputFilterAwareInterface
{

    public $store_id;
    public $domain;
    public $email;
    public $password;
    public $name;
    public $public_status;
    public $status;
    public $created;
    public $update;

    protected $inputFilter;

    public function exchangeArray($data)
    {
    //	var_dump($data);

     //   $this->store_url = (isset($data['store_url'])) ? $data['store_url'] : null;
        $this->store_id  = (isset($data['store_id'])) ? $data['store_id'] : null;
        $this->domain  = (isset($data['domain'])) ? $data['domain'] : null;
        $this->email  = (isset($data['email'])) ? $data['email'] : null;
        $this->password  = (isset($data['password'])) ? $data['password'] : null;
        $this->name  = (isset($data['name'])) ? $data['name'] : null;
        $this->public_status  = (isset($data['public_status'])) ? $data['public_status'] : null;
        $this->status  = (isset($data['status'])) ? $data['status'] : null;
        $this->created  = (isset($data['created'])) ? $data['created'] : null;
        $this->update  = (isset($data['update'])) ? $data['update'] : null;

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


            $inputFilter->add($factory->createInput(array(
                'name'     => 'store_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
            		'name'     => 'domain',
            		'required' => true,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
            						'name'    => 'StringLength',
            						'options' => array(
            								'encoding' => 'UTF-8',
            								'min'      => 1,
            								'max'      => 100,
            						),
            				),
            		),
            )));

            $inputFilter->add($factory->createInput(array(
            		'name'     => 'email',
            		'required' => true,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
            						'name'    => 'StringLength',
            						'options' => array(
            								'encoding' => 'UTF-8',
            								'min'      => 1,
            								'max'      => 100,
            						),
            				),
            		),
            )));

            $inputFilter->add($factory->createInput(array(
            		'name'     => 'password',
            		'required' => true,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
            						'name'    => 'StringLength',
            						'options' => array(
            								'encoding' => 'UTF-8',
            								'min'      => 1,
            								'max'      => 20,
            						),
            				),
            		),
            )));

            $inputFilter->add($factory->createInput(array(
            		'name'     => 'name',
            		'required' => false,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
            						'name'    => 'StringLength',
            						'options' => array(
            								'encoding' => 'UTF-8',
            								'min'      => 1,
            								'max'      => 255,
            						),
            				),
            		),
            )));

            $inputFilter->add($factory->createInput(array(
            		'name'     => 'public_status',
            		'required' => true,

            )));

            $inputFilter->add($factory->createInput(array(
            		'name'     => 'status',
            		'required' => true,

            )));

            $inputFilter->add($factory->createInput(array(
            		'name'     => 'created',
            		'required' => true,

            )));

            $inputFilter->add($factory->createInput(array(
            		'name'     => 'updated',
            		'required' => true,

            )));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


}
