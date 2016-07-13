<?php

    class Admin_ServicesController extends Zend_Controller_Action {
        
        public function indexAction() {
          
            $flashMessenger = $this->getHelper('FlashMessenger');
            
            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors')
            );
            
            // prikaz svih servisa
            $cmsServicesDbTable = new Application_Model_DbTable_CmsServices();
            $select = $cmsServicesDbTable->select();
            $select->order('order_number ASC');
            $services = $cmsServicesDbTable->fetchAll($select);
            
            $this->view->services = $services;
            $this->view->systemMessages = $systemMessages;
        }
        
        public function addAction() {
            $request = $this->getRequest(); //podaci iz url-a iz forme sa koje dolazimo 
            $flashMessenger = $this->getHelper('FlashMessenger');  // za prenosenje sistemskih poruka

            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors'),
            );
            
            $form = new Application_Form_Admin_ServiceAdd();
            
            //default form data
            $form->populate(array(
                
            ));
            
            // kad prvi put dolazimo onda je get method, a ako smo preko forme onda je post method
            if ($request->isPost() && $request->getPost('task') === 'saveNewService') {

                try {
                    //check form is valid
                    if (!$form->isValid($request->getPost())) {
                        throw new Application_Model_Exception_InvalidInput('Invalid data was sent for new service');
                    }

                    //get form data
                    $formData = $form->getValues(); // dobijamo filtrirane i validirane podatke
                    $cmsServicesTable = new Application_Model_DbTable_CmsServices();
                    $cmsServicesTable->insertService($formData);
                    
                    //set system message
                    $flashMessenger->addMessage('Service has been saved.', 'success');

                    //redirect to same or another page
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_services',
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
                throw new Zend_Controller_Router_Exception('Invalid service id: ' . $id, 404); // ovako prekidamo izvrsavanje programa i prikazujemo 'page not found'
            }
            $cmsServicesTable = new Application_Model_DbTable_CmsServices();
            $service = $cmsServicesTable->getServiceById($id);
            
            if (empty($service)) {
                throw new Zend_Controller_Router_Exception('No service is found with id: ' . $id, 404);
            }
            
//            print_r($member);
//            die();
            
            $flashMessenger = $this->getHelper('FlashMessenger');  // za prenosenje sistemskih poruka

            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors'),
            );

            $form = new Application_Form_Admin_ServiceAdd();
            
            //default form data
            $form->populate($service); //$member je sam po sebi array
            
            
            // kad prvi put dolazimo onda je get method, a ako smo preko forme onda je post method
            if ($request->isPost() && $request->getPost('task') === 'serviceUpdate') {

                try {
                    //check form is valid
                    if (!$form->isValid($request->getPost())) {
                        throw new Application_Model_Exception_InvalidInput('Invalid data was sent for service ');
                    }

                    //get form data
                    $formData = $form->getValues(); // dobijamo filtrirane i validirane podatke
                    
                    //radimo update postojeceg zapisa u tabeli
                    $cmsServicesTable->updateService($formData, $service['id']);
                    //$cmsServicesTable->updateService('id = ' . $service['id'], $formData);

                    //set system message
                    $flashMessenger->addMessage('Member has been updated.', 'success');

                    //redirect to same or another page
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_services',
                                'action' => 'index'
                                ), 'default', true);
                } 
                catch (Application_Model_Exception_InvalidInput $ex) {
                    $systemMessages['errors'][] = $ex->getMessage();
                }
                
            }

            $this->view->systemMessages = $systemMessages;
            $this->view->form = $form;
            
            $this->view->member = $service;
            
	}
        
        
        
    }

