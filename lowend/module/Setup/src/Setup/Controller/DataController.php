<?php

namespace Setup\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DataController extends AbstractActionController
{
    public function indexAction()
    {
    	$this->layout('layout/setup');
    }
}
