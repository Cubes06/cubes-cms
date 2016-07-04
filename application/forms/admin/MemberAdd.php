<?php

    class Application_Form_Admin_MemberAdd extends Zend_Form {
        
        public function init() {
            $firstName = new Zend_Form_Element_Text('first_name'); //string mora da odgovara name atributu
            // $firstName->addFilter(new Zend_Filter_StringTrim());
            // $firstName->addValidator(new Zend_Validate_StringLength(array('min' => 3, 'max' => 255)));
            $firstName->addFilter('StringTrim')
                    ->addValidator('StringLength', FALSE, array('min' => 3, 'max' => 255))
                    ->setRequired(true); //false ili true = gledaj naredne validacije ili nemoj da gledas ako pukne na ovome
            
            $this->addElement($firstName);
            
            
            $lastName = new Zend_Form_Element_Text('last_name');
            $lastName->addFilter('StringTrim')
                    ->addValidator('StringLength', FALSE, array('min' => 3, 'max' => 255))
                    ->setRequired(true);
            
            $this->addElement($lastName);
            
            $workTitle = new Zend_Form_Element_Text('work_title');
            $workTitle->addFilter('StringTrim')
                    ->addValidator('StringLength', FALSE, array('min' => 3, 'max' => 255))
                    ->setRequired(FALSE);
            
            $this->addElement($workTitle);
            
            $email = new Zend_Form_Element_Text('email');
            $email->addFilter('StringTrim')
                    ->addValidator('EmailAddress', FALSE, array('domain' => false))
                    ->setRequired(true);
            
            $this->addElement($email);
            
            
            $resume = new Zend_Form_Element_Textarea('resume');
            $resume->addFilter('StringTrim')
                    ->setRequired(FALSE);
            
            $this->addElement($resume);
        }

        
    }