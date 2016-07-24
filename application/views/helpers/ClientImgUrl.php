<?php

    class Zend_View_Helper_ClientImgUrl extends Zend_View_Helper_Abstract {
        public function clientImgUrl($client) {
            
            $clientImgFileName = $client['id'] . '.jpg';
            
            $clientImgFilePath = PUBLIC_PATH . "/uploads/clients/" . $clientImgFileName;
           
            
            if (is_file($clientImgFilePath)) {
                return $this->view->baseUrl('/uploads/clients/' . $clientImgFileName);
            }
            else {
                return $this->view->baseUrl('/uploads/clients/no-image.jpg');
            }
            
        }

    }

