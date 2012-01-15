<?php
    require_once("class.database.php");
    class Person
    {
        private $_sql;
        
        public function getAllDoctors()
        {
            $this->_sql = "SELECT firstName,lastName,personId FROM person where personType='d' ORDER BY firstName";
            return Database::getInstance()->getTable($this->_sql);
        }
        
        public function getMyPatients($myId, $number = false)
        {   
            if($number == true)
            {
                $this->_sql = "SELECT count(personId) AS totalPerson FROM person where personType='p' AND accepted='a' AND docId=$myId ORDER BY firstName";
                return Database::getInstance()->getRow($this->_sql);
            }
            else
            {
                $this->_sql = "SELECT * FROM person where personType='p' AND accepted='a' AND docId=$myId ORDER BY firstName";
                return Database::getInstance()->getTable($this->_sql);
            }
        }
        
        public function getRequestingPatient($myId, $number = false)
        {      
            if($number == true)
            {
                $this->_sql = "SELECT count(personId) AS totalPerson FROM person where personType='p' AND accepted='n' AND docId=$myId ORDER BY firstName";
                return Database::getInstance()->getRow($this->_sql);
            }
            else
            {
                $this->_sql = "SELECT * FROM person where personType='p' AND accepted='n' AND docId=$myId ORDER BY firstName";
                return Database::getInstance()->getTable($this->_sql);
            }
        }
        
        public function acceptPatient($id)
        {
            $this->_sql = "UPDATE person SET accepted = 'a' WHERE personId = $id";
            return Database::getInstance()->update($this->_sql);
        }
        
        public function rejectPatient($id)
        {
            $this->_sql = "UPDATE person SET accepted = 'r' WHERE personId = $id";
            return Database::getInstance()->update($this->_sql);
        }
        
        public function getMyDoctor($myId)
        {
            $this->_sql = "SELECT * from person where personType='d' ";
            $this->_sql = $this->_sql."AND personId=(SELECT docId from person where personId=$myId)";
            
            return Database::getInstance()->getRow($this->_sql);    
        }
        
        public function getMyDetails($myId)
        {
            $this->_sql = "SELECT * from person where personId = $myId";
            return Database::getInstance()->getRow($this->_sql);
        }
        
        public function deletePerson($id)
        {
            $this->_sql = "DELETE FROM person WHERE personId = $id";
            return Database::getInstance()->update($this->_sql);
        }
    }
?>