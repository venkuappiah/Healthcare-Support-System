<?php
    require_once("class.database.php");
    require_once("interface.input_validator.php");
    require_once("class.validator.php");
    
    class Registration implements InputValidator
    {
        private $_registrationData;
        private $_failure;
        private $_success;
        
        public function __construct($registrationData)
        {
            $this->_failure = array();
            $this->_success = array();
            $this->_registrationData = $registrationData;
        }
        
        private function _getIndex($keyParam)
        {
            $count = 0;
            foreach($this->_registrationData as $key=>$value)
            {
                if($keyParam == $key) return $count;
                ++$count;
            }
        }
        
        //removes fields that don't go to database
        //inserts the dob field in the proper place which goes to database
        private function _resetRegistrationDataArray()
        {
            unset($this->_registrationData['retypePassword']);
            
            $dob = $this->_registrationData['dobYear']."-".$this->_registrationData['dobMonth']."-".$this->_registrationData['dobDay'];
            
            $index = $this->_getIndex('dobYear');
            unset($this->_registrationData['dobYear']);
            unset($this->_registrationData['dobMonth']);
            unset($this->_registrationData['dobDay']);
            
            //returns the specified section of the array
            //maintains the old array keys in the new array
            $ar1 = array_slice($this->_registrationData,0,$index,true);
            $ar2 = array('dob'=>$dob);
            $ar3 = array_slice($this->_registrationData,$index-1,count($this->_registrationData),true);
            
            $this->_registrationData = array_merge($ar1,$ar2,$ar3);
            
            //encrypt the password with 32bit encryption algorithm
            $this->_registrationData['password'] = md5($this->_registrationData['password']);
        }
        
        public function doRegistration()
        {
            $this->_resetRegistrationDataArray();
            
            if(isset($this->_success['emailAddressS']))
            {
                $this->_checkDuplicateId();        
            }
            
            //all data are valid
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
        
        private function _checkDuplicateId()
        {
            $sql = "SELECT emailAddress FROM person WHERE emailAddress = '{$this->_registrationData['emailAddress']}'";
            $emailAddress = Database::getInstance()->getRow($sql);
            if(is_array($emailAddress))
            {
               $this->_failure['duplicateEmailAddress']= "duplicate";
            }
        }
        
        public function validateInput()
        {
            Validator::initialize($this->_registrationData);
            Validator::checkFirstName();
            Validator::checkLastName();
            Validator::checkPhoneNumber();
            Validator::checkMobileNumber();
            Validator::checkEmailAddress();
            Validator::checkStreet();
            Validator::checkSuburb();
            Validator::checkState();
            Validator::checkCity();
            Validator::checkPostcode();
            Validator::checkYear();
            Validator::checkMonth();
            Validator::checkDay();
            Validator::checkSex();
            Validator::checkPassword();
            Validator::checkID();
            
            $this->_success = Validator::getSuccessArray();
            $this->_failure = Validator::getFailureArray();
        }
        
         private function _getSQL()
        {
            $fields = implode(",",array_keys($this->_registrationData));
            $values = "";
            
            foreach($this->_registrationData as $key=>$value)
            {
                $values = $values."'".addslashes($value)."',";
            }
            $values = substr($values,0,strlen($values)-1);
            return "INSERT INTO person(".$fields.")VALUES(".$values.")";
        }
    }
?>