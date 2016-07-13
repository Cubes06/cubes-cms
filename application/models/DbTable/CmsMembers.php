<?php

    class Application_Model_DbTable_CmsMembers extends Zend_Db_Table_Abstract {

        const STATUS_ENABLED = 1;
        const STATUS_DISABLED = 0;

        protected $_name = 'cms_members';  //ovde ide naziv tabele

        /**
         * 
         * @param int $id
         * @return null|array Associative array as cms_members table columns or NULL if not found
         */
        public function getMemberById($id) {
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
        
        
                    
//                $data = array(
//                    'updated_on'      => '2007-03-23',
//                    'bug_status'      => 'FIXED'
//                );
//
//                $n = $db->update('bugs', $data, 'bug_id = 2');
        
        public function updateMember ($id, $member) {

            if (isset($member['id'])) {
                //Forbid changing of user id
                unset($member['id']);
            }
            $this->update($member, 'id = ' . $id);
        }

        /**
         * 
         * @param array $member  Associative array as cms_members table columns or NULL if not found
         * @return int $id od novog usera
         */
        public function insertMember($member) {
            //fetch order number for new member
            
            $id = $this->insert($member);
                        
            return $id;
        }
        
        /**
         * 
         * @param int $id ID of member to delete
         */
        public function deleteMember($id) {
            $this->delete('id = ' . $id);
        }
        
        /**
         * 
         * @param int $id    ID of member to disable
         */
        public function disableMember($id) {
            $this->update(array(
                'status' => self::STATUS_DISABLED
            ), 'id = ' . $id);
        }
        
        /**
         * 
         * @param int $id    ID of member to enable
         */
        public function enableMember($id) {
            $this->update(array(
                'status' => self::STATUS_ENABLED
            ), 'id = ' . $id);
        }
        
        
        
        
        
        
        
        
    }
