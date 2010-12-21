<?php
/**
 * App_Model_Users
 *  
 * @author Enrico Zimuel (enrico@zimuel.it)
 * @version 0.2
 */
require_once 'Zend/Db/Table/Abstract.php';
class App_Model_Users extends Zend_Db_Table_Abstract
{
    protected $_name = 'users';
    protected $_primary = 'username';
}