<?php

class Application_Form_Admin_UserAdd extends Zend_Form {
    
    // Overajdovan init metoda
    public function init() {
        
        $username = new Zend_Form_Element_Text('username');
        $username->addFilter('StringTrim')
                ->addValidator('StringLength', false, array('min' => 3, 'max' => 50))
                ->addValidator(
                        new Zend_Validate_Db_NoRecordExists(
                            array(
                                'table' => 'cms_users',
                                'field' => 'username'
                            )
                        )
                )
                ->setRequired(true);
        $this->addElement($username);
        
        
        $firstName = new Zend_Form_Element_Text('first_name');
        //$firstName->addFilter(new Zend_Filter_StringTrim());
        //$firstName->addValidator(new Zend_Validate_StringLength(array('min' => 3, 'max' => 255)));
        $firstName->addFilter('StringTrim')
                ->addValidator('StringLength', false, array('min' => 3, 'max' => 255))
                ->setRequired(FALSE);
        
        $this->addElement($firstName);
        
        $lastName = new Zend_Form_Element_Text('last_name');
        $lastName->addFilter('StringTrim')
                ->addValidator('StringLength', false, array('min' => 3, 'max' => 255))
                ->setRequired(FALSE);
        $this->addElement($lastName);
             
        $email = new Zend_Form_Element_Text('email');
        $email->addFilter('StringTrim')
                ->addValidator('EmailAddress', false, array('domain' => false))
                ->setRequired(FALSE);
        $this->addElement($email);
        
    }

    
}
