<?php

class Application_Form_Admin_UserEdit extends Zend_Form {
    
    protected $editedUserId;
    
    public function __construct($editedUserId, $options = null) {
        if (empty($editedUserId)) {
            throw new InvalidArgumentException('Edited user id can not be empty');
        }
        
        $this->editedUserId = $editedUserId;
        
        parent::__construct($options);
    }

    
    // Overajdovan init metoda
    public function init() {
        
        $username = new Zend_Form_Element_Text('username');
        $username->addFilter('StringTrim')
                ->addValidator('StringLength', false, array('min' => 3, 'max' => 50))
                ->addValidator(
                        new Zend_Validate_Db_NoRecordExists(
                            array(
                                'table' => 'cms_users',
                                'field' => 'username',
                                'exclude' => array(
                                                'field' => 'id',
                                                'value' => $this->editedUserId
                                            )
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
