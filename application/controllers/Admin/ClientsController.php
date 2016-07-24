<?php

    use Intervention\Image\ImageManagerStatic as Image;

    class Admin_ClientsController extends Zend_Controller_Action {
        
        public function indexAction() {
            
            $flashMessenger = $this->getHelper('FlashMessenger');
            
            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors')
            );
            
            // prikaz svih client-a
            $cmsClientsDbTable = new Application_Model_DbTable_CmsClients();
            // $select jed objekat klase Zend_Db_Select
            $select = $cmsClientsDbTable->select();
            $select->order('order_number ASC');
            
            //debug za db select - vrace se sql upit
            //die($select->assemble());
                   
            $clients = $cmsClientsDbTable->fetchAll($select);
            
            $this->view->clients = $clients;
            $this->view->systemMessages = $systemMessages;
        }
        
        
        public function addAction() {
            $request = $this->getRequest();

            $flashMessenger = $this->getHelper('FlashMessenger');
            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors'),
            );
            
            $form = new Application_Form_Admin_ClientAdd();

            if ($request->isPost() && $request->getPost('task') === 'save') {
                try {
                    if (!$form->isValid($request->getPost())) {
                        throw new Application_Model_Exception_InvalidInput('Invalid data was sent for new client');
                    }
                    
                    $formData = $form->getValues();
                    
                    unset($formData['client_photo']);
                    
                    $cmsClientsTable = new Application_Model_DbTable_CmsClients();
                    
                    $clientId = $cmsClientsTable->insertClient($formData);
                    
                    if ($form->getElement('client_photo')->isUploaded()) {
                       
                        $fileInfos = $form->getElement('client_photo')->getFileInfo('client_photo');
                        $fileInfo = $fileInfos['client_photo'];
                        
                        try {
                            //Open uploaded photo in temporary directory
                            $clientPhoto = Image::make($fileInfo['tmp_name']);
                            $clientPhoto->fit(170, 70);
                            $clientPhoto->save(PUBLIC_PATH . '/uploads/clients/' . $clientId . '.jpg');
                        } 
                        catch (Exception $ex) {
                            //set system message
                            $flashMessenger->addMessage('Client has been saved but error occured during image proccessing.', 'errors');
                            //redirect to same or another page
                            $redirector = $this->getHelper('Redirector');
                            $redirector->setExit(true)
                                    ->gotoRoute(array(
                                        'controller' => 'admin_clients',
                                        'action' => 'edit',
                                        'id' => $clientId
                                            ), 'default', true);
                        }
                    }
                    //set system message
                    $flashMessenger->addMessage('Client has been successfully created.', 'success');
                    //redirect to same or another page
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_clients',
                                'action' => 'index'
                                    ), 'default', true);
                } catch (Application_Model_Exception_InvalidInput $ex) {
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
                throw new Zend_Controller_Router_Exception('Invalid client id: ' . $id, 404); // ovako prekidamo izvrsavanje programa i prikazujemo 'page not found'
            }
            
            $cmsClientsTable = new Application_Model_DbTable_CmsClients();
            $client = $cmsClientsTable->getClientById($id);
            
            if (empty($client)) {
                throw new Zend_Controller_Router_Exception('No client is found with id: ' . $id, 404);
            }
            
//            print_r($client);
//            die();
            
            $flashMessenger = $this->getHelper('FlashMessenger');  // za prenosenje sistemskih poruka

            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors'),
            );

            $form = new Application_Form_Admin_ClientEdit();
            
            //default form data
            $form->populate($client); //$client je sam po sebi array
            
            
            // kad prvi put dolazimo onda je get method, a ako smo preko forme onda je post method
            if ($request->isPost() && $request->getPost('task') === 'update') {

                try {
                    //check form is valid
                    if (!$form->isValid($request->getPost())) {
                        throw new Application_Model_Exception_InvalidInput('Invalid data was sent for client ');
                    }
                    
                    //get form data
                    $formData = $form->getValues(); // dobijamo filtrirane i validirane podatke
                    unset($formData['client_photo']);
                    
                    
                        
                    if ($form->getElement('client_photo')->isUploaded()) {
                        $fileInfos = $form->getElement('client_photo')->getFileInfo('client_photo');
                        $fileInfo = $fileInfos['client_photo'];

                        try {
                            //Open uploaded photo in temporary directory
                            $clientPhotoEdit = Image::make($fileInfo['tmp_name']);

                            $clientPhotoEdit->fit(170, 70);

                            $clientPhotoEdit->save(PUBLIC_PATH . '/uploads/clients/' . $client['id'] . '.jpg');
                        } 
                        catch (Exception $ex) {
                            throw new Application_Model_Exception_InvalidInput('Error occured during image proccessing.');
                        }
                    }
                    
                    //radimo update postojeceg zapisa u tabeli
                    $cmsClientsTable->updateClient($client['id'], $formData);
                    
                    // do actual task
                    //save to database etc
                    
                    //set system message
                    $flashMessenger->addMessage('Client has been updated.', 'success');

                    //redirect to same or another page
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_clients',
                                'action' => 'index'
                                ), 'default', true);
                } 
                catch (Application_Model_Exception_InvalidInput $ex) {
                    $systemMessages['errors'][] = $ex->getMessage();
                }
                
            }

            $this->view->systemMessages = $systemMessages;
            $this->view->form = $form;
            
            $this->view->client = $client;
            
	}
        
     
        public function deleteAction() {
            
            $request = $this->getRequest();
            
            if (!$request->isPost() || $request->getPost('task') != 'delete') {
                // request is not post or task is not delete
                // redirect to index page
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_clients',
                            'action' => 'index'
                            ), 'default', true);
            }
            
            $flashMessenger = $this->getHelper('FlashMessenger'); 
            
            try {
                $id = (int) $request->getPost('id'); // isto sto i read $_POST['id']

                if ($id <= 0) {
                    throw new Application_Model_Exception_InvalidInput('Invalid client id: ' . $id);
                }

                $cmsClientsTable = new Application_Model_DbTable_CmsClients();
                $client = $cmsClientsTable->getClientById($id);

                if (empty($client)) {
                    throw new Application_Model_Exception_InvalidInput('No client is found with id: ' . $id, 'errors');
                }

                $cmsClientsTable->deleteClient($id);
                $flashMessenger->addMessage('Client ' . $client['first_name'] . ' ' . $client['last_name'] . ' has been deleted.', 'success');
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_clients',
                                'action' => 'index'
                                ), 'default', true);
            } 
            catch (Application_Model_Exception_InvalidInput $ex) {
                $flashMessenger->addMessage($ex->getMessage(), 'errors');
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_clients',
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
                            'controller' => 'admin_clients',
                            'action' => 'index'
                            ), 'default', true);
            }
            
            $flashMessenger = $this->getHelper('FlashMessenger'); 
            
            try {
                $id = (int) $request->getPost('id'); // isto sto i read $_POST['id']

                if ($id <= 0) {
                    throw new Application_Model_Exception_InvalidInput('Invalid client id: ' . $id);
                }

                $cmsClientsTable = new Application_Model_DbTable_CmsClients();
                $client = $cmsClientsTable->getClientById($id);

                if (empty($client)) {
                    throw new Application_Model_Exception_InvalidInput('No client is found with id: ' . $id, 'errors');
                }

                $cmsClientsTable->disableClient($id);
                $flashMessenger->addMessage('Client ' . $client['first_name'] . ' ' . $client['last_name'] . ' has been disabled.', 'success');
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_clients',
                                'action' => 'index'
                                ), 'default', true);
            } 
            catch (Application_Model_Exception_InvalidInput $ex) {
                $flashMessenger->addMessage($ex->getMessage(), 'errors');
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_clients',
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
                            'controller' => 'admin_clients',
                            'action' => 'index'
                            ), 'default', true);
            }
            
            $flashMessenger = $this->getHelper('FlashMessenger'); 
            
            try {
                $id = (int) $request->getPost('id'); // isto sto i read $_POST['id']

                if ($id <= 0) {
                    throw new Application_Model_Exception_InvalidInput('Invalid client id: ' . $id);
                }

                $cmsClientsTable = new Application_Model_DbTable_CmsClients();
                $client = $cmsClientsTable->getClientById($id);

                if (empty($client)) {
                    throw new Application_Model_Exception_InvalidInput('No client is found with id: ' . $id, 'errors');
                }

                $cmsClientsTable->enableClient($id);
                $flashMessenger->addMessage('Client ' . $client['first_name'] . ' ' . $client['last_name'] . ' has been enabled.', 'success');
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_clients',
                                'action' => 'index'
                                ), 'default', true);
            } 
            catch (Application_Model_Exception_InvalidInput $ex) {
                $flashMessenger->addMessage($ex->getMessage(), 'errors');
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_clients',
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
                            'controller' => 'admin_clients',
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
                
                
                $cmsClientsTable = new Application_Model_DbTable_CmsClients();
                
                $cmsClientsTable->updateOrderOfClients($sortedIds);
                
                
                $flashMessenger->addMessage('Order is successfully saved', 'success');
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_clients',
                            'action' => 'index'
                            ), 'default', true);
            }
            catch (Application_Model_Exception_InvalidInput $ex) {
                $flashMessenger->addMessage($ex->getMessage(), 'errors');
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_clients',
                            'action' => 'index'
                            ), 'default', true);
            }
               
            $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_clients',
                            'action' => 'index'
                            ), 'default', true);          
        }
        
    }

