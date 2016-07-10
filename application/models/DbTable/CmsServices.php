<?php

    class Application_Model_DbTable_CmsServices extends Zend_Db_Table_Abstract {
        
        const STATUS_ENABLED = 1; 
        const STATUS_DISABLED = 0;

        protected $_name = 'cms_services';

        /**
         * 
         * @param int $id
         * @return null|array   Associative array as cms_services table columns or NULL if not found
         */
        public function getServiceById($id) {
            $select = $this->select();
            $select->where("id = ?", $id);

            $row = $this->fetchRow($select);

            if ($row instanceof Zend_Db_Table_Row) {
                return $row->toArray();
            }
            else {
                return null;
            }
        } //end of function

        /**
         * @param int $id
         * @param array $service   Associative array with keys as column names and values as column new values
         */
        public function updateService($id, $service) {
            if (isset($service['id'])) {
                //Forbid changing of user id
                unset($service['id']);
            }
            $this->update($service, 'id = ' . $id);
        }
        

        public function insertService($service) {
            //fetch order number for new member
            $id->insert($service);         
            return $id;
        }
    }

