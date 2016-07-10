<?php
    class Application_Form_Admin_ServiceAdd extends Zend_Form {

        // Overajdovan init metoda
        public function init() {
            
            $title = new Zend_Form_Element_Text('title');
            $title->addFilter('StringTrim')
                    ->addValidator('StringLength', false, array('min' => 2, 'max' => 255))
                    ->setRequired(true);
            $this->addElement($title);
            
            $icon = new Zend_Form_Element_Text('icon');
            $icon->addFilter('StringTrim')
                    ->addValidator('StringLength', false, array('min' => 2, 'max' => 255))
                    ->setRequired(true);
            $this->addElement($icon);

            $description = new Zend_Form_Element_Textarea('description');
            $description->addFilter('StringTrim')
                    ->setRequired(false);
            $this->addElement($description);
        }


    }
