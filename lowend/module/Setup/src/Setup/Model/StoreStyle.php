<?php
namespace Setup\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import

class StoreStyle implements InputFilterAwareInterface
{

    public $store_id;
    public $logo;
    public $layout;
    public $background;
    public $title_text_color;
    public $menu_text_color;
    public $item_text_color;
    public $price_text_color;
    public $item_display_flag;
    public $price_display_flag;
    public $frame_display_flag;


    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->store_id  = (isset($data['store_id'])) ? $data['store_id'] : null;
        $this->logo  = (isset($data['logo'])) ? $data['logo'] : null;
        $this->layout  = (isset($data['layout'])) ? $data['layout'] : null;
        $this->background  = (isset($data['background'])) ? $data['background'] : null;
        $this->title_text_color  = (isset($data['title_text_color'])) ? $data['title_text_color'] : null;
        $this->menu_text_color  = (isset($data['menu_text_color'])) ? $data['menu_text_color'] : null;
        $this->item_text_color  = (isset($data['item_text_color'])) ? $data['item_text_color'] : null;
        $this->price_text_color  = (isset($data['price_text_color'])) ? $data['price_text_color'] : null;
        $this->item_display_flag  = (isset($data['item_display_flag'])) ? $data['item_display_flag'] : null;
        $this->price_display_flag  = (isset($data['price_display_flag'])) ? $data['price_display_flag'] : null;
        $this->frame_display_flag  = (isset($data['frame_display_flag'])) ? $data['frame_display_flag'] : null;

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
