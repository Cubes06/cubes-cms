<?php

class ServicesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $cmsServicesDbTable = new Application_Model_DbTable_CmsServices();
        $select = $cmsServicesDbTable->select();
        $select->where('status = ?', Application_Model_DbTable_CmsServices::STATUS_ENABLED)
                ->order('order_number ASC');
        
        $services = $cmsServicesDbTable->fetchAll($select);
        $this->view->services = $services;
        
    }


}

