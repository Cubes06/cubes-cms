<?php

    class Admin_UsersController extends Zend_Controller_Action {
        
        public function indexAction() {
            
            $cmsUsersDbTable = new Application_Model_DbTable_CmsUsers();
            $users = $cmsUsersDbTable->fetchAll()->toArray();
            $this->view->users = $users;
            
        }
        
        public function addAction() {
            
        }
        
        public function editAction() {
            
        }
        
        
        //za domaci
        public function deleteAction() {
            
        }
        
        public function enableAction() {
            
        }
        
        public function disableAction() {
            
        }
        
    }