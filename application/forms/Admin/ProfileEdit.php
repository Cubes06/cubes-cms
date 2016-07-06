<?php

    class Application_Form_Admin_ProfileEdit extends Zend_Form {
        public function init() {
            $firstName = new Zend_Form_Element_Text('first_name'); //string mora da odgovara name atributu
            $firstName->addFilter('StringTrim')
                    ->addValidator('StringLength', FALSE, array('min' => 3, 'max' => 255))
                    ->setRequired(true); //false ili true = gledaj naredne validacije ili nemoj da gledas ako pukne na ovome
            
            $this->addElement($firstName);
            
            
            $lastName = new Zend_Form_Element_Text('last_name');
            $lastName->addFilter('StringTrim')
                    ->addValidator('StringLength', FALSE, array('min' => 3, 'max' => 255))
                    ->setRequired(true);
            
            $this->addElement($lastName);
            
                        
            $email = new Zend_Form_Element_Text('email');
            $email->addFilter('StringTrim')
                    ->addValidator('EmailAddress', FALSE, array('domain' => false))
                    ->setRequired(true);
            
            $this->addElement($email);
        }

    }


