<?php

    class Admin_UsersController extends Zend_Controller_Action {
        
        public function indexAction() {
            
            $flashMessenger = $this->getHelper('FlashMessenger');
            
            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors')
            );
            
            $cmsUsersDbTable = new Application_Model_DbTable_CmsUsers();
            $users = $cmsUsersDbTable->fetchAll()->toArray();
            $this->view->users = $users;
            $this->view->systemMessages = $systemMessages;
            
        }
        
        public function addAction() {
            $request = $this->getRequest(); //podaci iz url-a iz forme sa koje dolazimo 
            $flashMessenger = $this->getHelper('FlashMessenger');  // za prenosenje sistemskih poruka

            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors'),
            );

            $form = new Application_Form_Admin_UserAdd();
            
            //default form data
            $form->populate(array(
                
            ));
            
            // kad prvi put dolazimo onda je get method, a ako smo preko forme onda je post method
            if ($request->isPost() && $request->getPost('task') === 'save') {

                try {
                    //check form is valid
                    if (!$form->isValid($request->getPost())) {
                        throw new Application_Model_Exception_InvalidInput('Invalid data was sent for new user');
                    }

                    //get form data
                    $formData = $form->getValues(); // dobijamo filtrirane i validirane podatke
                    
                    
                    $cmsUsersTable = new Application_Model_DbTable_CmsUsers();
                    
                    $cmsUsersTable->insertUser($formData);
                    

                    // do actual task
                    //save to database etc
                    
                    //set system message
                    $flashMessenger->addMessage('User has been saved.', 'success');

                    //redirect to same or another page
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_users',
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
                throw new Zend_Controller_Router_Exception('Invalid user id: ' . $id, 404); // ovako prekidamo izvrsavanje programa i prikazujemo 'page not found'
            }
            
            $loggedInUser = Zend_Auth::getInstance()->getIdentity();
            
            if ($id == $loggedInUser['id']) {
                //throw new Zend_Controller_Router_Exception('Go to edit profile page! ' . $id, 404);
                $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_profile',
                                'action' => 'edit'
                                ), 'default', true);
            }
            
            $cmsUsersTable = new Application_Model_DbTable_CmsUsers();
            $user = $cmsUsersTable->getUserById($id);
            
            if (empty($user)) {
                throw new Zend_Controller_Router_Exception('No user is found with id: ' . $id, 404);
            }
            
//            print_r($member);
//            die();
            
            $flashMessenger = $this->getHelper('FlashMessenger');  // za prenosenje sistemskih poruka

            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors'),
            );

            $form = new Application_Form_Admin_UserEdit($id);
            
            //default form data
            $form->populate($user); //$member je sam po sebi array
            
            
            // kad prvi put dolazimo onda je get method, a ako smo preko forme onda je post method
            if ($request->isPost() && $request->getPost('task') === 'update') {

                try {
                    //check form is valid
                    if (!$form->isValid($request->getPost())) {
                        throw new Application_Model_Exception_InvalidInput('Invalid data was sent for user ');
                    }

                    //get form data
                    $formData = $form->getValues(); // dobijamo filtrirane i validirane podatke
                    
                    
                    //radimo update postojeceg zapisa u tabeli
                    $cmsUsersTable->updateUser($user['id'], $formData);
                    

                    // do actual task
                    //save to database etc
                    
                    //set system message
                    $flashMessenger->addMessage('User has been updated.', 'success');

                    //redirect to same or another page
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_users',
                                'action' => 'index'
                                ), 'default', true);
                } 
                catch (Application_Model_Exception_InvalidInput $ex) {
                    $systemMessages['errors'][] = $ex->getMessage();
                }
                
            }

            $this->view->systemMessages = $systemMessages;
            $this->view->form = $form;
            
            $this->view->member = $user;
            
	}
        
        
        
        
        //za domaci
        public function deleteAction() {
            
        }
        
        public function enableAction() {
            
        }
        
        public function disableAction() {
            
        }
        
    }