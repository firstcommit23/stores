<?php
namespace Top\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator;

class Signup implements InputFilterAwareInterface
{
    public $id;
    public $domain;
    public $email;
    public $password;
    protected $inputFilter;

    public function exchangeArray($data)
    {

        $this->id           = (isset($data['id']))            ? $data['id']     : null;
        $this->domain           = (isset($data['domain']))            ? $data['domain']     : null;
        $this->email      = (isset($data['email']))       ? $data['email']     : null;
        $this->password    = (isset($data['password']))     ? $data['password']     : null;

    }
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }


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
                'name'     => 'id',
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
                		'name' =>'NotEmpty',
                		'options' => array(
                			'messages' => array(
                					\Zend\Validator\NotEmpty::IS_EMPTY => 'URLを入力してください。'
                				),
                	 		),
                		),
                	array(
                		'name' => 'StringLength',
                		'options' => array(
                			'encoding' => 'UTF-8',
                			'min' => 5,
                			'max' => 20,
                			'messages' => array(
                			'stringLengthTooShort' => 'URLは4~20文字以内で入力してください。',
                			'stringLengthTooLong' => 'URLは4~20文字以内で入力してください。'
                					),
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
                		'name' =>'NotEmpty',
                		'options' => array(
                			'messages' => array(
                					\Zend\Validator\NotEmpty::IS_EMPTY => 'メールアドレスを入力してください。'
                				),
                	 		),
                		),
                	array(
                		'name' => 'StringLength',
                		'options' => array(
                			'encoding' => 'UTF-8',
                			'min' => 5,
                			'max' => 20,
                			'messages' => array(
                			'stringLengthTooShort' => 'メールアドレスは4~20文字以内で入力してください。',
                			'stringLengthTooLong' => 'メールアドレスは4~20文字以内で入力してください。'
                					),
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
                		'name' =>'NotEmpty',
                		'options' => array(
                			'messages' => array(
                					\Zend\Validator\NotEmpty::IS_EMPTY => 'パスワードを入力してください。'
                				),
                	 		),
                		),
                	array(
                		'name' => 'StringLength',
                		'options' => array(
                			'encoding' => 'UTF-8',
                			'min' => 5,
                			'max' => 20,
                			'messages' => array(
                			'stringLengthTooShort' => 'パスワードは4~20文字以内で入力してください。',
                			'stringLengthTooLong' => 'パスワードは4~20文字以内で入力してください。'
                					),
                			),
                	),
                ),
            )));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}