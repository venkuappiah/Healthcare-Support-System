<?php
    require_once("class.database.php");
    class WebService
    {
        public function authenticateUser($username,$password)
        {
            $sql = "SELECT CONCAT_WS(' ','Name:',firstName, lastName) AS name, CONCAT('Sex: ',sex) AS sex, ";
            $sql = $sql."CONCAT('Age: ',YEAR(CURRENT_DATE) - YEAR(dob)) AS age, personId FROM person WHERE ";
            $sql = $sql."emailAddress = '$username' AND password = '".md5($password)."' AND personType = 'p' AND accepted = 'a'";
            
            //if user exists returns an integer
            //if user does not exist returns empty string;
        
            $array = Database::getInstance()->getTable($sql);
            $credentials = "";
            if(is_array($array) && count($array)){
                foreach($array as $subArray){
                    foreach($subArray as $value)
                        $credentials = $credentials.$value."~"; 
                }
                //$credentials = substr($credentials, 0, strlen($credentials) - 1);
            }
            
            //$sql = "SELECT mobileNumber FROM person WHERE personId IN(";
            //$sql = $sql."SELECT docId FROM person WHERE emailAddress = '$username' AND password = '".md5($password)."' AND personType = 'p' AND accepted = 'a')";
            return $credentials;
        }
        
        public function addTemperature($id,$temperature)
        {
            $sql = "INSERT INTO medicalrecord(personId,dateTime,temperature)VALUES($id,now(),$temperature)";
            
            //if insertion succeeds returns an integer
            //if insertion fails returns -1
            return (Database::getInstance()->insertRow($sql));
        }
        
        
        public function sendSMS($id,$temperature)
        {
            $retMsg = "";
            $message = "";
            
            $objPerson = new Person();
            $doctor = $objPerson->getMyDoctor($id);
            $patient = $objPerson->getMyDetails($id);
            
            $message = $message.$patient['firstName']." ".$patient['lastName']."'s details\n";
            $message = $message."==============";
            $message = $message."Temperature:".number_format($temperature,2)."\n";
            
            //displays like 2010-Jul-05
            $message = $message."Date:".date("Y-M-d")."\n";
                                             
            //displays like  1:05:19PM                                                            
            $message = $message."Time:".date("g:i:sA")."\n";
            $message = $message."Contact:".$patient['mobileNumber']."\n";
            $message = $message."==============";
            $message = $message."Healthcare Support System\n";
            $message = $message."***Thank You***\n";
            
            // Open Headwind GSM Modem Driver
            $hgsmdrv = new COM("HeadwindGSM.SMSDriver");
            
            if(!$hgsmdrv)
            {
                //Can not open the modem driver
                $retMsg = "Unable to send message";
            }
            else 
            {
                $hgsmdrv->Connect();
                
                // Create message
                $sms = new COM("HeadwindGSM.SMSMessage");
                if(!$sms)
                {
                    //Can not create the message object
                    $retMsg = "Unable to send message";
                }
                else
                {
                    $sms->To = $doctor['mobileNumber'];
                    $sms->Body = $message;
                    // Send message
                    $sms->Send();
                    $retMsg = "Message successfully sent to your doctor.";
                }
                
                //free the objects
                $hgsmdrv = null;
                $sms = null;
            }
            return $retMsg;
        }
    }
?>