<?php
require_once('class.database.php');
require_once('interface.input_validator.php');
require_once('class.validator.php');

class Discussion implements InputValidator
{
    private $_discussionData;
    private $_success;
    private $_failure;
    private $_message;
    private $_sql;
    
    public function __construct($discussionData = null)
    {
        $this->_discussionData = $discussionData;
        $this->_success = array();
        $this->_failure = array();
        $this->_message = array();   
    }
    
    public function getMessageId($id)
    {
        $sql = "SELECT discussionId from discussion WHERE postedTo = $id ORDER BY datetime DESC";
        return Database::getInstance()->getTable($sql);
    }
    
    public function getMessage($id)
    {
        $sql = "SELECT * from discussion WHERE postedTo = $id ORDER BY datetime DESC";
        return Database::getInstance()->getTable($sql);
    }
    
    public function getMessageSender($id, $isDiscussionId = null)
    {
        if($isDiscussionId)
        {
            $sql = "SELECT CONCAT_WS( ' ',firstName, lastName ) AS name, emailAddress, datetime, discussionSubject, ";
            $sql = $sql."discussionContent FROM person, discussion WHERE person.personId = discussion.postedBy AND discussion.discussionId = $id";
            
            //returns an one-dimension array on success
            //returns -1 on failure
            return Database::getInstance()->getRow($sql);
        }
        else
        {
            $sql = "SELECT CONCAT_WS( ' ', firstName, lastName ) AS name, emailAddress FROM person, discussion ";
            $sql = $sql."WHERE person.personId = discussion.postedBy AND discussion.postedTo =$id ORDER BY datetime DESC";
    
            //returns a two-dimension array on success
            //returns -1 on failure
            return Database::getInstance()->getTable($sql);
        }
        
    }
    
    public function setViewStatus($status,$id)
    {
        $sql = "UPDATE discussion set isViewed = $status WHERE discussionId = $id";
        //returns number of rows updated on success
        //returns -1 on failure
        return Database::getInstance()->update($sql);
    }
    
    public function deleteMessage($id)
    {
        $sql = "DELETE FROM discussion WHERE discussionId = $id";
        //returns number of rows deleted on success
        //returns -1 on failure
        return Database::getInstance()->update($sql);
    }
    
    public function getUnreadMessages($id)
    {
        $sql = "SELECT count( discussionId ) AS unread FROM discussion WHERE postedTo = $id AND isViewed =0";
        return Database::getInstance()->getID($sql);
    }
    
    public function validateInput()
    {
        Validator::initialize($this->_discussionData);
        //Validator::checkID();
        Validator::checkSubject();
        Validator::checkMessage();
        
        $this->_success = Validator::getSuccessArray();
        $this->_failure = Validator::getFailureArray();
    }
    
    public function save()
    {
        if(!count($this->_failure))
        {
            return Database::getInstance()->insertRow($this->_getSQL());
        }
        //some data are valid and some are invalid
        else if (count($this->_success))
        {   
            return array_merge($this->_success,$this->_failure);
        }
        //all data are invalid
        else
        {
            return $this->_failure;
        }   
    }
    
    private function _getSQL()
    {
        $fields = implode(",",array_keys($this->_discussionData));
        $values = "";
        
        foreach($this->_discussionData as $key=>$value)
        {
            if(is_numeric($value))
            {
                $values = $values.$value;   
            }
            else
            {
                $values = $values."'".addslashes($value)."'";
            }
            $values = $values.",";
        }
        $values = substr($values,0,strlen($values)-1);
        
        return "INSERT INTO discussion(".$fields.")VALUES(".$values.")";
    }
}
?>