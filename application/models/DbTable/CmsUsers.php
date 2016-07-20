<?php

    class Application_Model_DbTable_CmsUsers extends Zend_Db_Table_Abstract {

        const STATUS_ENABLED = 1; // ovo su sad nove konstante (odnose sa na ovu klasu)
        const STATUS_DISABLED = 0;
        const DEFAULT_PASSWORD = 'cubesphp';

        protected $_name = 'cms_users';  //ovde ide naziv tabele

        /**
         * 
         * @param int $id
         * @return null|array   Associative array as cms_users table columns or NULL if not found
         */
        public function getUserById($id) {
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

        /**
         * @param int $id
         * @param array $user   Associative array with keys as column names and values as column new values
         */
        public function updateUser($id, $user) {

            if (isset($user['id'])) {
                //Forbid changing of user id
                unset($user['id']);
            }

            $this->update($user, 'id = ' . $id);

        }
        
        /**
         * @param int $id
         * @param string $newPassword  Plain password, not hashed
         */
        public function changeUserPassword ($id, $newPassword) {
            //update "password" column, set md5 value of new password for user with id = $id
            $this->update(array('password' => md5($newPassword)), 'id = ' . $id);
        }
        
        
        /**
         * 
         * @param array $user
         * @return int ID of new user
         */
        public function insertUser($user) {
            //set default password for new user
            $user['password'] = md5(self::DEFAULT_PASSWORD);
            
            
            
            $id = $this->insert($user);
                        
            return $id;
        }


    }