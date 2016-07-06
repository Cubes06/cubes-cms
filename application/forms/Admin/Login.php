<?php

class Application_Form_Admin_Login extends Zend_Form
{
	public function init() {
		
		//kreiranje elementa, u kontruktor ide naziv polja tj vrednost name atributa
		$username = new Zend_Form_Element_Text('username');
		
		$username->addFilter('StringTrim')
			->addFilter('StringToLower')
			->setRequired(true);// naznacuje se da je element obavezan
		
		//dodavanje elementa u formu
		$this->addElement($username);
		
		$password = new Zend_Form_Element_Password('password');
		$password->setRequired(true);
		$this->addElement($password);
	}
}