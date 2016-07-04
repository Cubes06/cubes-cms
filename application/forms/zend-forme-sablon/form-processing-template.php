<?php

    $request = $this->getRequest();
    $flashMessenger = $this->getHelper('FlashMessenger');

    $form = new Application_Form_Path_To_The_Form();

    //default form data
    $form->populate(array(
        'fieldName1' => 'fieldValue1',
        'fieldName2' => 'fieldValue2',
        'fieldName3' => 'fieldValue3',
    ));

    $systemMessages = array(
        'success' => $flashMessenger->getMessages('success'),
        'errors' => $flashMessenger->getMessages('errors'),
        'info' => $flashMessenger->getMessages('errors'),
    );

    if ($request->isPost() && $request->getPost('task') === 'taskName') {

        try {

            //check form is valid
            if (!$form->isValid($request->getPost())) {
                throw new Application_Model_Exception_InvalidInput('Invalid form data bla bla');
            }

            //get form data
            $formData = $form->getValues();

            // do actual task
            //save to database etc
            //set system message
            $flashMessenger->addMessage('Task is successfull', 'success');

            //redirect to same or another page
            $redirector = $this->getHelper('Redirector');
            $redirector->setExit(true)
                    ->gotoRoute(array(
                        'controller' => 'controllerName',
                        'action' => 'actionName',
                        'param1' => $param1Value
                            ), 'default', true);
        } catch (Application_Model_Exception_InvalidInput $ex) {
            $systemMessages['errors'][] = $ex->getMessage();
        }
    }

    $this->view->systemMessages = $systemMessages;
    $this->view->form = $form;
