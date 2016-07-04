<?php

    class Application_Model_DbTable_CmsMembers extends Zend_Db_Table_Abstract {
        const STATUS_ENABLED = 1;
        const STATUS_DISABLED = 0;
        protected $_name = 'cms_members';
    }
