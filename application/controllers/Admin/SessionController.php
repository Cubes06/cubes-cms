<?php

    class Admin_SessionController extends Zend_Controller_Action {
        
        public function indexAction() {
            
            //provera da li je ulogovan
            if (Zend_Auth::getInstance()->hasIdentity()) {
                //ulogovan je
                //redirect na admin_dashboard kontroler i index akciju
                $redirector = $this->getHelper('Redirector');
                $redirector instanceof Zend_Controller_Action_Helper_Redirector;

                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_dashboard',
                            'action' => 'index',
                        ), 'default', TRUE); 
            }
            else {
                $redirector = $this->getHelper('Redirector');
                $redirector instanceof Zend_Controller_Action_Helper_Redirector;

                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_session',
                            'action' => 'login',
                        ), 'default', TRUE); 
            }
            
        }
        
        public function loginAction() {
            
            //Disable-ovanje layout-a
            Zend_Layout::getMvcInstance()->disableLayout();
            
            $loginForm = new Application_Form_Admin_Login();
            
            // ove dve linije moraju zajedno da bi radio autocomplete kasnije
            $request = $this->getRequest();  
            $request instanceof Zend_Controller_Request_Http;
            
            $flashMessenger = $this->getHelper('FlashMessenger');
            
            $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'error' => $flashMessenger->getMessages('errors')
            );
            
            if ($request->isPost() && $request->getPost("task") === "login") {
                
                if ($loginForm->isValid($request->getPost())) {
                    
                    $authAdapter = new Zend_Auth_Adapter_DbTable();
                    $authAdapter->setTableName('cms_users')
                            ->setIdentityColumn('username')
                            ->setCredentialColumn('password')
                            ->setCredentialTreatment('MD5(?) AND status != 0');  //ovo je izraz u mySql-u
                    
                    $authAdapter->setIdentity($loginForm->getValue('username'));
                    $authAdapter->setCredential($loginForm->getValue('password'));
                    
                    $auth = Zend_Auth::getInstance();
                    $result = $auth->authenticate($authAdapter);
                    
                    if ($result->isValid()) {
                        
                        // Smestanje kompletnog reda iz tabele cms_users kao identifikator da je korisnik ulogovan
                        // Po defaultu se smesta samo username, a ovako smestamo asocijativni niz, tj. row iz tabele
                        // Asocijativni niz $user ima kljuceve koji su u stvari nazivi kolona u tableli cms_users
                        $user = (array) $authAdapter->getResultRowObject();
                        $auth->getStorage()->write($user);
                        
                        $redirector = $this->getHelper('Redirector');
                        $redirector instanceof Zend_Controller_Action_Helper_Redirector;

                        $redirector->setExit(true)
                                ->gotoRoute(array(
                                    'controller' => 'admin_dashboard',
                                    'action' => 'index',
                                ), 'default', TRUE); 
                                    $systemMessage = 'OK';
                    }
                    else {
                        $systemMessages['errors'][] = 'Wrong username or password.';
                    }
                    
                }
                else {
                    $systemMessages['errors'][] = 'Username and password are required.';
                }
                
            }
            
            $this->view->systemMessages = $systemMessages;
            
        }
        
        public function logoutAction() {
            $auth = Zend_Auth::getInstance();
            
            $flashMessenger = $this->getHelper('FlashMessenger');
            $flashMessenger->addMessage('You have been logged out', 'success');
            
            //Brise identifikator da je neko ulogovan
            $auth->clearIdentity();
            
            
            
            //Ovde ide redirect na login stranu
            $redirector = $this->getHelper('Redirector');
            $redirector instanceof Zend_Controller_Action_Helper_Redirector;
            
            $redirector->setExit(true)
                    ->gotoRoute(array(
                        'controller' => 'admin_session',
                        'action' => 'login',
                    ), 'default', TRUE); //prvi par. # drugi je rutiranje, treci resetuj mi zapamcene vrednosti
            
            /*
            //redirect ako nemamo dodatne parametre
            $redirector->setExit(true)
                    ->gotoSimple('login', 'admin_session');
            //isto kao da smo napisali
            $redirector->setExit(true)
                    ->gotoUrl('/admin_session/login');
            //redirect na spoljni link
            $redirector->setExit(true)
                    ->setPrependBase(false)
                    ->gotoUrl('https://www.facebook.com');
            */
            
        }
        
        
        
    }