<?php

    class Zend_View_Helper_MemberImgUrl extends Zend_View_Helper_Abstract {
        public function memberImgUrl($member) {
            
            $memberImgFileName = $member['id'] . '.jpg';
            
            $memberImgFilePath = PUBLIC_PATH . "/uploads/members/" . $memberImgFileName;
            
            //Helper ima propery view koji je Zend_View
            //i preko kojeg pozivamo ostale view helpere
            //na primer $this->view->baseUrl()
            
            
            if (is_file($memberImgFilePath)) {
                return $this->view->baseUrl('/uploads/members/' . $memberImgFileName);
            }
            else {
                return $this->view->baseUrl('/uploads/members/no-image.jpg');
            }
            
        }

    }

