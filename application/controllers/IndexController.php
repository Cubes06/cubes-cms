<?php

    class IndexController extends Zend_Controller_Action {

        public function init() {
            $cmsClientsDbTable = new Application_Model_DbTable_CmsClients();
            
            $select = $cmsClientsDbTable->select();
            $select->order('order_number ASC');
                   
            $clients = $cmsClientsDbTable->fetchAll($select);
            
            $this->view->clients = $clients;
            $this->view->systemMessages = $systemMessages;
        }

        public function indexAction() {
            // action body
        }
        
        public function testAction() {
            
        }
    }
