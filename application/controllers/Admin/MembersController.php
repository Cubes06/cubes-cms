<?php

    class Admin_MembersController extends Zend_Controller_Action {
        
        public function indexAction() {
            
            $flashMessenger = $this->getHelper('FlashMessenger');
            
            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors')
            );
            
            // prikaz svih member-a
            $cmsMembersDbTable = new Application_Model_DbTable_CmsMembers();
            // $select jed objekat klase Zend_Db_Select
            $select = $cmsMembersDbTable->select();
            $select->order('order_number ASC');
            
            //debug za db select - vrace se sql upit
            //die($select->assemble());
                   
            $members = $cmsMembersDbTable->fetchAll($select);
            
            $this->view->members = $members;
            $this->view->systemMessages = $systemMessages;
        }
        
        
        public function addAction() {
            $request = $this->getRequest(); //podaci iz url-a iz forme sa koje dolazimo 
            $flashMessenger = $this->getHelper('FlashMessenger');  // za prenosenje sistemskih poruka

            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors'),
            );

            $form = new Application_Form_Admin_MemberAdd();
            
            //default form data
            $form->populate(array(
                
            ));
            
            // kad prvi put dolazimo onda je get method, a ako smo preko forme onda je post method
            if ($request->isPost() && $request->getPost('task') === 'save') {

                try {
                    //check form is valid
                    if (!$form->isValid($request->getPost())) {
                        throw new Application_Model_Exception_InvalidInput('Invalid data was sent for new member');
                    }

                    //get form data
                    $formData = $form->getValues(); // dobijamo filtrirane i validirane podatke
                    
                    //unset $formData['member_photo'];
                    
                    $cmsMembersTable = new Application_Model_DbTable_CmsMembers();
                    
                    $cmsMembersTable->insertMember($formData);
                    

                    // do actual task
                    //save to database etc
                    
                    //set system message
                    $flashMessenger->addMessage('Member has been saved.', 'success');

                    //redirect to same or another page
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_members',
                                'action' => 'index'
                                ), 'default', true);
                } 
                catch (Application_Model_Exception_InvalidInput $ex) {
                    $systemMessages['errors'][] = $ex->getMessage();
                }
                
            }

            $this->view->systemMessages = $systemMessages;
            $this->view->form = $form;
        }
        
        public function editAction() {
		
	    $request = $this->getRequest();
            
            $id = (int) $request->getParam('id'); //(int) pretvara slova u nule
            
            if ($id <= 0) {
                throw new Zend_Controller_Router_Exception('Invalid member id: ' . $id, 404); // ovako prekidamo izvrsavanje programa i prikazujemo 'page not found'
            }
            
            $cmsMembersTable = new Application_Model_DbTable_CmsMembers();
            $member = $cmsMembersTable->getMemberById($id);
            
            if (empty($member)) {
                throw new Zend_Controller_Router_Exception('No member is found with id: ' . $id, 404);
            }
            
//            print_r($member);
//            die();
            
            $flashMessenger = $this->getHelper('FlashMessenger');  // za prenosenje sistemskih poruka

            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors'),
            );

            $form = new Application_Form_Admin_MemberAdd();
            
            //default form data
            $form->populate($member); //$member je sam po sebi array
            
            
            // kad prvi put dolazimo onda je get method, a ako smo preko forme onda je post method
            if ($request->isPost() && $request->getPost('task') === 'update') {

                try {
                    //check form is valid
                    if (!$form->isValid($request->getPost())) {
                        throw new Application_Model_Exception_InvalidInput('Invalid data was sent for member ');
                    }

                    //get form data
                    $formData = $form->getValues(); // dobijamo filtrirane i validirane podatke
                    
                    
                    //radimo update postojeceg zapisa u tabeli
                    $cmsMembersTable->updateMember($member['id'], $formData);
                    

                    // do actual task
                    //save to database etc
                    
                    //set system message
                    $flashMessenger->addMessage('Member has been updated.', 'success');

                    //redirect to same or another page
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_members',
                                'action' => 'index'
                                ), 'default', true);
                } 
                catch (Application_Model_Exception_InvalidInput $ex) {
                    $systemMessages['errors'][] = $ex->getMessage();
                }
                
            }

            $this->view->systemMessages = $systemMessages;
            $this->view->form = $form;
            
            $this->view->member = $member;
            
	}
        
     
        public function deleteAction() {
            
            $request = $this->getRequest();
            
            if (!$request->isPost() || $request->getPost('task') != 'delete') {
                // request is not post or task is not delete
                // redirect to index page
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_members',
                            'action' => 'index'
                            ), 'default', true);
            }
            
            $flashMessenger = $this->getHelper('FlashMessenger'); 
            
            try {
                $id = (int) $request->getPost('id'); // isto sto i read $_POST['id']

                if ($id <= 0) {
                    throw new Application_Model_Exception_InvalidInput('Invalid member id: ' . $id);
                }

                $cmsMembersTable = new Application_Model_DbTable_CmsMembers();
                $member = $cmsMembersTable->getMemberById($id);

                if (empty($member)) {
                    throw new Application_Model_Exception_InvalidInput('No member is found with id: ' . $id, 'errors');
                }

                $cmsMembersTable->deleteMember($id);
                $flashMessenger->addMessage('Member ' . $member['first_name'] . ' ' . $member['last_name'] . ' has been deleted.', 'success');
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_members',
                                'action' => 'index'
                                ), 'default', true);
            } 
            catch (Application_Model_Exception_InvalidInput $ex) {
                $flashMessenger->addMessage($ex->getMessage(), 'errors');
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_members',
                            'action' => 'index'
                            ), 'default', true);
            }
            
        }
        
        
        public function disableAction() {
            
            $request = $this->getRequest();
            
            if (!$request->isPost() || $request->getPost('task') != 'disable') {
                // request is not post or task is not disable
                // redirect to index page
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_members',
                            'action' => 'index'
                            ), 'default', true);
            }
            
            $flashMessenger = $this->getHelper('FlashMessenger'); 
            
            try {
                $id = (int) $request->getPost('id'); // isto sto i read $_POST['id']

                if ($id <= 0) {
                    throw new Application_Model_Exception_InvalidInput('Invalid member id: ' . $id);
                }

                $cmsMembersTable = new Application_Model_DbTable_CmsMembers();
                $member = $cmsMembersTable->getMemberById($id);

                if (empty($member)) {
                    throw new Application_Model_Exception_InvalidInput('No member is found with id: ' . $id, 'errors');
                }

                $cmsMembersTable->disableMember($id);
                $flashMessenger->addMessage('Member ' . $member['first_name'] . ' ' . $member['last_name'] . ' has been disabled.', 'success');
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_members',
                                'action' => 'index'
                                ), 'default', true);
            } 
            catch (Application_Model_Exception_InvalidInput $ex) {
                $flashMessenger->addMessage($ex->getMessage(), 'errors');
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_members',
                            'action' => 'index'
                            ), 'default', true);
            }
            

            
        }
        
              
        public function enableAction() {
            
            $request = $this->getRequest();
            
            if (!$request->isPost() || $request->getPost('task') != 'enable') {
                // request is not post or task is not disable
                // redirect to index page
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_members',
                            'action' => 'index'
                            ), 'default', true);
            }
            
            $flashMessenger = $this->getHelper('FlashMessenger'); 
            
            try {
                $id = (int) $request->getPost('id'); // isto sto i read $_POST['id']

                if ($id <= 0) {
                    throw new Application_Model_Exception_InvalidInput('Invalid member id: ' . $id);
                }

                $cmsMembersTable = new Application_Model_DbTable_CmsMembers();
                $member = $cmsMembersTable->getMemberById($id);

                if (empty($member)) {
                    throw new Application_Model_Exception_InvalidInput('No member is found with id: ' . $id, 'errors');
                }

                $cmsMembersTable->enableMember($id);
                $flashMessenger->addMessage('Member ' . $member['first_name'] . ' ' . $member['last_name'] . ' has been enabled.', 'success');
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_members',
                                'action' => 'index'
                                ), 'default', true);
            } 
            catch (Application_Model_Exception_InvalidInput $ex) {
                $flashMessenger->addMessage($ex->getMessage(), 'errors');
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_members',
                            'action' => 'index'
                            ), 'default', true);
            }
            

            
        }
        
        
        public function updateorderAction() {
            
            $request = $this->getRequest();
            
            if (!$request->isPost() || $request->getPost('task') != 'saveOrder') {
                // request is not post or task is not disable
                // redirect to index page
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_members',
                            'action' => 'index'
                            ), 'default', true);
            }
            
            $flashMessenger = $this->getHelper('FlashMessenger'); 
            
            
            try {
                
                $sortedIds = $request->getPost('sorted_ids');
                
                if (empty($sortedIds)) {
                    throw new Application_Model_Exception_InvalidInput('Sorted ids are not sent.');
                }
                $sortedIds = trim($sortedIds, ' ,');
                if (!preg_match('/^[0-9]+(,[0-9]+)*$/', $sortedIds)) {
                    throw new Application_Model_Exception_InvalidInput('Invalid sorted ids: ' . $sortedIds);
                }
                
                $sortedIds = explode(',', $sortedIds);
                
                
                $cmsMembersTable = new Application_Model_DbTable_CmsMembers();
                
                $cmsMembersTable->updateOrderOfMembers($sortedIds);
                
                
                $flashMessenger->addMessage('Order is successfully saved', 'success');
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_members',
                            'action' => 'index'
                            ), 'default', true);
            }
            catch (Application_Model_Exception_InvalidInput $ex) {
                $flashMessenger->addMessage($ex->getMessage(), 'errors');
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_members',
                            'action' => 'index'
                            ), 'default', true);
            }
               
            $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_members',
                            'action' => 'index'
                            ), 'default', true);          
        }
        
    }

