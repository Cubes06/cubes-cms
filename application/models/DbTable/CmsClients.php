<?php

    class Application_Model_DbTable_CmsClients extends Zend_Db_Table_Abstract {

        const STATUS_ENABLED = 1;
        const STATUS_DISABLED = 0;

        protected $_name = 'cms_clients';  //ovde ide naziv tabele

        /**
         * 
         * @param int $id
         * @return null|array Associative array as cms_clients table columns or NULL if not found
         */
        public function getClientById($id) {
            $select = $this->select();
            $select->where("id = ?", $id);

            $row = $this->fetchRow($select);

            if ($row instanceof Zend_Db_Table_Row) {
                return $row->toArray();
            }
            else {
                return null;
            }

        }

        public function updateClient ($id, $client) {

            if (isset($client['id'])) {
                //Forbid changing of user id
                unset($client['id']);
            }
            $this->update($client, 'id = ' . $id);
        }
        
        public function updateOrderOfClients($sortedIds) {
            
            foreach ($sortedIds as $orderNumber => $id) {
                $this->update(array(
                        'order_number' => $orderNumber + 1 
                    ), 'id = ' . $id);
            }
        }
        
        

        /**
         * 
         * @param array $client  Associative array as cms_clients table columns or NULL if not found
         * @return int $id od novog usera
         */
        public function insertClient($client) {
            //fetch order number for new client
            
            $id = $this->insert($client);
                        
            return $id;
        }
        
        /**
         * 
         * @param int $id ID of client to delete
         */
        public function deleteClient($id) {
            $this->delete('id = ' . $id);
        }
        
        /**
         * 
         * @param int $id    ID of client to disable
         */
        public function disableClient($id) {
            $this->update(array(
                'status' => self::STATUS_DISABLED
            ), 'id = ' . $id);
        }
        
        /**
         * 
         * @param int $id    ID of client to enable
         */
        public function enableClient($id) {
            $this->update(array(
                'status' => self::STATUS_ENABLED
            ), 'id = ' . $id);
        }
        

        
    }
