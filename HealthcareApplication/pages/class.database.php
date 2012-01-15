<?php
    class Database
    {
        private $_server;
        private $_username;
        private $_password;
        private $_database;
        private $_hCon;
        
        private static $_instance;
        
        private function __construct()
        {
            $this->_server = "localhost";
            $this->_username = "root";
            $this->_password = "";
            $this->_database = "HealthcareSupportSystem";
            
            $this->_hCon = mysql_connect($this->_server,$this->_username,$this->_password) or die ("Connection to the server could not be established.");
            mysql_select_db($this->_database,$this->_hCon) or die ("Database not found.");
        }
        
        public static function getInstance()
        {
            if(!isset(self::$_instance))
            {
                self::$_instance = new Database();
            }
            
            return self::$_instance;
        }
        
        public function insertRow($query)
        {
            $res = mysql_query($query, $this->_hCon) or die(mysql_error());
            if (!is_resource($res))
                echo mysql_error($this->_hCon);
            
            if(mysql_affected_rows($this->_hCon))
                return mysql_insert_id($this->_hCon);
            else
                return -1;
        }        
    
        public function getTable($query)
        {
            $res = mysql_query($query, $this->_hCon);
            if (!is_resource($res))
                echo mysql_error($this->_hCon);
            
            $arResult = array();
            while($row = mysql_fetch_assoc($res)){
                $arResult[]=$row;
            }
            return $arResult;
        }
        
        public function getID($query)
        {
            $res = mysql_query($query,$this->_hCon);
            if(!is_resource($res))
                echo mysql_error($this->_hCon);
            
            $row = mysql_fetch_array($res);
            if(mysql_num_rows($res))
                return $row[0];
            else
                return -1;
        }
        
        public function update($query)
        {
            mysql_query($query);
            
            //returns number of rows deleted or updated on success
            //returns -1 on failure
            return mysql_affected_rows($this->_hCon);
        }
        
        public function getRow($query)
        {
            $res = mysql_query($query,$this->_hCon);
            if(!is_resource($res))
                echo mysql_error($this->_hCon);
            
            $row = mysql_fetch_array($res);
            if(mysql_num_rows($res) == 1)
                return $row;
            else
                return -1;
        }
    }
?>