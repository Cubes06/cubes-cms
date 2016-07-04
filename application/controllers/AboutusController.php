<?php

    class AboutusController extends Zend_Controller_Action {

        public function init() {
            /* Initialize action controller here */
        }

        public function indexAction() {
            $cmsMembersDbTable = new Application_Model_DbTable_CmsMembers();
            // $select jed objekat klase Zend Db
            $select = $cmsMembersDbTable->select();
            $select->where('status = ?', Application_Model_DbTable_CmsMembers::STATUS_ENABLED)
                    ->order('order_number ASC');
//                    ->order('first_name')
//                    ->order('last_name')
//                    ->limitPage(2, 3);
            
            //debug za db select - vrace se sql upit
            //die($select->assemble());
                   
            $members = $cmsMembersDbTable->fetchAll($select);
            
            $this->view->members = $members;
        }

        public function memberAction() {
            
            $request = $this->getRequest();
            $id = (int) $request->getParam("id");
            
            //filtriranje
            $id = trim($id);
            $id = (int) $id;
            
            //validacija
            if (empty($id)) {
                throw new Zend_Controller_Router_Exception("No member id", 404);
            }
            
            $cmsMembersDbTable = new Application_Model_DbTable_CmsMembers();
            $select = $cmsMembersDbTable->select();
            $select->where("id = ?", $id)
                    ->where("status = ?", Application_Model_DbTable_CmsMembers::STATUS_ENABLED);
            
            $foundMembers = $cmsMembersDbTable->fetchAll($select);
            if (count($foundMembers) <= 0) {
                throw new Zend_Controller_Router_Exception("No member is found for id: " . $id, 404);
            }
            
            $member = $foundMembers[0];
            //isto kao gore   $member = array_shift($foundMembers);
            
            //Fetching all other members
            $select = $cmsMembersDbTable->select();
            $select->where('status = ?', Application_Model_DbTable_CmsMembers::STATUS_ENABLED)
                    ->where('id != ?', $id)
                    ->order('order_number ASC');
            
            $members = $cmsMembersDbTable->fetchAll($select);
            
            $this->view->members = $members;
            $this->view->member = $member;
            
        }

    }
