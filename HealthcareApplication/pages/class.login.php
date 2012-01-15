<?php
require_once("class.database.php");

class Login
{
    private $_sql;
   
    public function doLogin($username, $password)
    {
        $this->_sql = "select personId,firstName,lastName,personType from person where emailAddress = '$username' and password = '".md5($password)."'";
        return Database::getInstance()->getRow($this->_sql);
    }
    
}
?>