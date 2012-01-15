<?php
    abstract class Validator
    {
        private static $_registrationData;
        private static $_success;
        private static $_failure;
        
        public static function getSuccessArray()
        {
            return self::$_success;
        }
        
        public static function getFailureArray()
        {
            return self::$_failure;
        }
        
        public static function initialize($registrationData)
        {
            self::$_registrationData = $registrationData;
            self::$_success = array();
            self::$_failure = array();
        }
        
        public static function checkFirstName()
        {
            if(!preg_match("/^[A-Za-z']+$/",self::$_registrationData['firstName']))
            {
                self::$_failure['fNameF'] = "e";
            }
            else
            {
                self::$_success['fNameS'] = self::$_registrationData['firstName'];
            } 
        }
        
        public static function checkLastName()
        {
            if(!preg_match("/^[A-Za-z']+$/",self::$_registrationData['lastName']))
            {
                self::$_failure['lNameF'] = "e";    
            }
            else
            {
                self::$_success['lNameS'] = self::$_registrationData['lastName'];   
            }
        }
        
        public static function checkID()
        {
            if(isset(self::$_registrationData['docId']))
            {
                if(is_numeric(self::$_registrationData['docId'])&& self::$_registrationData['docId'] > 0)
                {
                    self::$_success['docIdS'] = self::$_registrationData['docId'];   
                }
                else
                {
                    self::$_success['docIdF'] = "e";
                }
            }
            if(isset(self::$_registrationData['personId']))
            {
                if(is_numeric(self::$_registrationData['personId'])&& self::$_registrationData['personId'] > 0)
                {
                    self::$_success['personIdS'] = self::$_registrationData['personId'];   
                }
                else
                {
                    self::$_failure['personIdF'] = "e";
                }
            }
            
        }
        public static function checkSubject()
        {
            if(self::$_registrationData['discussionSubject']=="")
            {
                self::$_failure['discussionSubjectF'] = "e";
            }
            else
            {
                self::$_success['discussionSubjectS'] = self::$_registrationData['discussionSubject'];
            }  
        }
        
        public static function checkMessage()
        {
            if(self::$_registrationData['discussionContent']=="")
            {
                self::$_failure['discussionContentF'] = "e";
            }
            else
            {
                self::$_success['discussionContentS'] = self::$_registrationData['discussionContent'];
            }  
        }
        
        public static function checkPhoneNumber()
        {
            //phonenumber has following format: areacode-phonenumber
            //area code must be one of the following: 02 or 03 or 08 or 07
            //phone number must have 8 digits
            //area code and phone number must be separated by hyphen
            if(!preg_match("/^[0](8|2|7|3)-[0-9]{8}$/",self::$_registrationData['phoneNumber']))
            {
                self::$_failure['phoneNumberF'] = "e";
            }
            else
            {
                self::$_success['phoneNumberS'] = self::$_registrationData['phoneNumber'];
            }
        }
        
        public static function checkMobileNumber()
        {
            //mobile number must have 10 digits altogether
            //first digit must start from 0
            if(!preg_match("/^0[0-9]{9}$/",self::$_registrationData['mobileNumber']))
            {
                self::$_failure['mobileNumberF'] = "e";
            }
            else
            {
                self::$_success['mobileNumberS'] = self::$_registrationData['mobileNumber'];
            }
        }
        
        public static function checkEmailAddress()
        {
            //email adddress has the following format: username@subdomain.domain
            //must not start with a digit
            //each part must have at least 2 characters
            if(!preg_match("/^[^0-9][a-z0-9_]+[@][a-z]+[.][a-z]{2,}([.][a-z]{2})?$/",self::$_registrationData['emailAddress']))
            {
                self::$_failure['emailAddressF'] = "e";
            }
            else
            {
                self::$_success['emailAddressS'] = self::$_registrationData['emailAddress'];
            }  
        }
        
        public static function checkStreet()
        {
            //street must have following format: digit/digit string
            if(!preg_match("/^[0-9]+[\/][0-9]+[ ]([a-zA-Z.'][ ]?)+$/",self::$_registrationData['street']))
            {
                self::$_failure['streetF'] = "e";
            }
            else
            {
                self::$_success['streetS'] = self::$_registrationData['street'];
            }
        }
        
        public static function checkSuburb()
        {
            //suburb can hold only alphabets and spaces
            if(!preg_match("/^[a-zA-z ]+$/",self::$_registrationData['suburb']))
            {
                self::$_failure['suburbF'] = "e";
            }
            else
            {
                self::$_success['suburbS'] = self::$_registrationData['suburb'];
            } 
        }
        
        public static function checkState()
        {
            //state can hold only alphabets and spaces
            if(!preg_match("/^[a-zA-z ]+$/",self::$_registrationData['state']))
            {
                self::$_failure['stateF'] = "e";
            }
            else
            {
                self::$_success['stateS'] = self::$_registrationData['state'];
            }   
        }
        
        public static function checkCity()
        {
            //city can hold only alphabets and spaces
            if(!preg_match("/^[a-zA-z ]+$/",self::$_registrationData['city']))
            {
                self::$_failure['cityF'] = "e";
            }
            else
            {
                self::$_success['cityS'] = self::$_registrationData['city'];
            }  
        }
        
        public static function checkPostcode()
        {
            //postcode can hold only digits of length 4
            //postcode must not start with 0
            if(!preg_match("/^[1-9][0-9]{3}$/",self::$_registrationData['postcode']))
            {
                self::$_failure['postcodeF'] = "e";
            }
            else
            {
                self::$_success['postcodeS'] = self::$_registrationData['postcode'];
            }  
        }
        
        /*
        public static function checkPersonType()
        {
            //personType can be either d or p
            if(!preg_match("/^(d|p)$/",self::$_registrationData['personType']))
            {
                self::$_failure['personTypeF'] = "e";
            }
            else
            {
                self::$_success['personTypeS'] = self::$_registrationData['personType'];
            }  
        }
        */
        
        public static function checkYear()
        {
            //year component can not start from zero and has exactly 4 digits            
            if(!preg_match("/^[1-9][0-9]{3}$/",self::$_registrationData['dobYear']))
            {
                self::$_failure['dobYearF'] = "e";
            }
            else
            {
                self::$_success['dobYearS'] = self::$_registrationData['dobYear'];
            }  
        }
        
        public static function checkMonth()
        {
            //month component has minimum 1 and maximum 2 digits
            if(!preg_match("/^[0-9]{1,2}$/",self::$_registrationData['dobMonth']))
            {
                self::$_failure['dobMonthF'] = "e";
            }
            else
            {
                self::$_success['dobMonthS'] = self::$_registrationData['dobMonth'];
            }  
        }
        
        public static function checkDay()
        {
            //day component has minimum 1 and maximum 2 digits
            if(!preg_match("/^[0-9]{1,2}$/",self::$_registrationData['dobDay']))
            {
                self::$_failure['dobDayF'] = "e";
            }
            else
            {
                self::$_success['dobDayS'] = self::$_registrationData['dobDay'];
            } 
        }
        
        public static function checkSex()
        {
            //sex can be either m or f
            if(!preg_match("/^[m|f]$/",self::$_registrationData['sex']))
            {
                self::$_failure['sexF'] = "e";
            }
            else
            {
                self::$_success['sexS'] = self::$_registrationData['sex'];
            }  
        }
        
        public static function checkPassword()
        {
            //password must be at least 5 characters long and at most 10 characters long
            if(strlen(self::$_registrationData['password']) < 5 || strlen(self::$_registrationData['password']) > 10)
            {
                self::$_failure['passwordF'] = "e";
            }
            //password must match with the retyped password
            else if (!(self::$_registrationData['password'] == self::$_registrationData['retypePassword']))
            {
                self::$_failure['passwordF'] = "e";
            }
            else
            {
                self::$_success['passwordS'] = self::$_registrationData['password'];
                self::$_success['retypePasswordS'] = self::$_registrationData['retypePassword'];
            }
        }
    }
?>