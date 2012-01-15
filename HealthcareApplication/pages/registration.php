<?php
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        require_once("class.registration.php");
        $doctor = array();
        $docId = 0;
        
        $personType = 'd';
        
        if(isset($_POST['selDoctor'])){
            $doctor = explode("+",$_POST['selDoctor']);
            $docId = $doctor[0];
            $personType = 'p';
        }
        
        $fName = trim($_POST['txtFirstName']);
        $lName = trim($_POST['txtLastName']);
        $phoneNumber = trim($_POST['txtPhoneNumber']);
        $mobileNumber = trim($_POST['txtMobileNumber']);
        $emailAddress = trim($_POST['txtEmailAddress']);
        $street = trim($_POST['txtStreet']);
        $suburb = trim($_POST['txtSuburb']);
        $state = $_POST['selState'];
        $city = isset($_POST['selCity'])? $_POST['selCity']: "";
        $postcode = $_POST['txtPostcode'];
        $year = $_POST['selYear'];
        $month = $_POST['selMonth'];
        $day = $_POST['selDay'];
        $sex = isset($_POST['radSex'])? $_POST['radSex']: "";
        $password = $_POST['txtPassword'];
        $retypePassword = $_POST['txtRetypePassword'];
        
        $registrationData = 
        array
        (
            'docId'=>$docId,
            'firstName'=>$fName,
            'lastName'=>$lName,
            'phoneNumber'=>$phoneNumber,
            'mobileNumber'=>$mobileNumber,
            'emailAddress'=>$emailAddress,
            'street'=>$street,
            'suburb'=>$suburb,
            'state'=>$state,
            'city'=>$city,
            'postcode'=>$postcode,
            'personType'=>$personType,
            'dobYear'=>$year,
            'dobMonth'=>$month,
            'dobDay'=>$day,
            'sex'=>$sex,
            'password'=>$password,
            'retypePassword'=>$retypePassword
        );
        
        $registration = new Registration($registrationData);
        $registration->validateInput();
        
        //sends new Id if the registration is successful, -1 if not successful, error array if invalid data were sent
        $status = $registration->doRegistration();
        
        //all data are valid
        if(!(is_array($status)))
        {
            $locationSuccess = "Location:../index.php?reg=t";
            $locationFailure = "Location:registration_form.php?reg=f";
            
            if($personType == "d")
            {
                $locationSuccess = "Location:activities.php?reg=t";
                $locationFailure = "Location:activities.php?reg=f";
            }
            
            if($status)
                //registration successful: go to the login page
                header($locationSuccess);
            else
                //registration failed: go to the registration page
                header($locationFailure);
        }
    }
?>