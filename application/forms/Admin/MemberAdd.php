<?php

class Application_Form_Admin_MemberAdd extends Zend_Form {
    
    // Overajdovan init metoda
    public function init() {
        $firstName = new Zend_Form_Element_Text('first_name');
        //$firstName->addFilter(new Zend_Filter_StringTrim());
        //$firstName->addValidator(new Zend_Validate_StringLength(array('min' => 3, 'max' => 255)));
        $firstName->addFilter('StringTrim')
                ->addValidator('StringLength', false, array('min' => 3, 'max' => 255))
                ->setRequired(true);
        
        $this->addElement($firstName);
        
        $lastName = new Zend_Form_Element_Text('last_name');
        $lastName->addFilter('StringTrim')
                ->addValidator('StringLength', false, array('min' => 3, 'max' => 255))
                ->setRequired(true);
        $this->addElement($lastName);
        
        $workTitle = new Zend_Form_Element_Text('work_title');
        $workTitle->addFilter('StringTrim')
                ->addValidator('StringLength', false, array('min' => 3, 'max' => 255))
                ->setRequired(false);
        $this->addElement($workTitle);
        
        $email = new Zend_Form_Element_Text('email');
        $email->addFilter('StringTrim')
                ->addValidator('EmailAddress', false, array('domain' => false))
                ->setRequired(true);
        $this->addElement($email);
        
        $resume = new Zend_Form_Element_Textarea('resume');
        $resume->addFilter('StringTrim')
                ->setRequired(false);
        $this->addElement($resume);
    }

    
}
