<?php
    date_default_timezone_set('Australia/Melbourne');
    require_once('session.php');
    require_once("registration.php");
    require_once("class.year.php");
    require_once("class.state.php");
    
    $objState = new State();
    $objYear = new Year(1900, date("Y"));
    
    $stateList = $objState->getStateList();
    $yearList = $objYear->getYearList();
    $monthList = $objYear->getMonthList();
    $daysList = $objYear->getDaysList();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system::Registration form page</title>
        <link rel = "stylesheet" type = "text/css" href="../css/style_sub.css" media="screen"></link>
        <script type = "text/javascript" src = "../js/cityAndState.js"></script>
    </head>
    
    <body onload = "updateCity(document.getElementById('state').selectedIndex)">
        <center>
            <?php
                include("../includes/header_sub.php");
            ?>
            <div class = "content">
                <h1>Healthcare support system::Registration</h1>
                <h2>Please fill in the doctor's details. All fields are required</h2>
                
                <div class = "logout">
                    <p>
                        <a href = "activities.php">Back</a> &nbsp;|&nbsp;
                        <a href = "../index.php?logout=t">Logout</a>
                    </p>
                </div>
                
                <form class = "registration_form" name = "frmRegistration" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "post">
                    <div class = "input">
                        <?php
                            $fName = isset($status['fNameS'])? $status['fNameS']:"";
                            $lName = isset($status['lNameS'])? $status['lNameS']:"";
                            $docId = isset($status['docIdS'])? $status['docIdS']:"";

                            if(isset($status['fNameF'])||isset($status['lNameF']))
                            {
                               echo "<p class = 'failure'>Invalid name. Please type in both fields.</p>";
                            }
                        ?>
                        <b class = "caption">Name</b>
                        <div class = "input_element">
                            <div>
                                <b class = "caption">First name</b>
                                <b class = "caption" style = "position:relative;left:90px;">Last name</b>
                            </div>
                            <input type = "text" <?php if(strlen($fName)) echo "value = '$fName'";?> size = "20" name = "txtFirstName"/>
                            <input type = "text" <?php if(strlen($lName)) echo "value = '$lName'";?> size = "20" name = "txtLastName"/>
                        </div>
                        <br/><br/><br/>
                                                
                        <?php $day = isset($status['dobDayS'])?$status['dobDayS']:""; ?>
                        <?php $month = isset($status['dobMonthS'])?$status['dobMonthS']:""; ?>
                        <?php $year = isset($status['dobYearS'])?$status['dobYearS']:""; ?>
                        <?php if(isset($status['dobDayF'])||isset($status['dobMonthF'])||isset($status['dobYearF'])) echo "<p class = 'failure'>Invalid selection. Please select valid date components from all three boxes.</p>";?>
                        <b class = "caption">DOB</b>
                        <div class = "input_element">
                            <select name = "selDay">
                                <option style = "color:#999999;">day</option>
                                <?php
                                    foreach($daysList as $thisDay)
                                    {
                                        if($thisDay == $day)
                                        {
                                            echo "<option value = '$thisDay' selected>$thisDay</option>";
                                        }
                                        else
                                        {
                                            echo "<option value = '$thisDay'>$thisDay</option>";
                                        }
                                    }
                                ?>
                            </select>&nbsp;&nbsp;
                            <select name = "selMonth">
                                <option style = "color:#999999;">month</option>
                                <?php
                                    foreach ($monthList as $thisMonth=>$monthDigit)
                                    {
                                        if($monthDigit == $month)
                                        {
                                            echo "<option value = '$monthDigit' selected>$thisMonth</option>";
                                        }
                                        else
                                        {
                                            echo "<option value = '$monthDigit'>$thisMonth</option>";
                                        }
                                    }
                                ?>
                            </select>&nbsp;&nbsp;
                            <select name = "selYear">
                                <option style = "color:#999999;">year</option>
                                <?php
                                    foreach($yearList as $thisYear)
                                    {
                                        if($thisYear == $year)
                                        {
                                            echo "<option value = '$thisYear' selected>$thisYear</option>";
                                        }
                                        else
                                        {
                                            echo "<option value = '$thisYear'>$thisYear</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <br/><br/>
                        
                        <?php if(isset($status['sexF'])) echo "<p class = 'failure'>Invalid selection. Please select a sex from the given options.</p>";?>
                        <?php $sex = isset($status['sexS'])? $status['sexS']: "";?>
                        <b class = "caption">Sex</b>
                        <div class = "input_element">
                            <input type = "radio" <?php if($sex == "f") echo "checked";?> name = "radSex" value="f"/><b>Female</b>
                            <input type = "radio" <?php if($sex == "m") echo "checked";?> name = "radSex" value = "m"/><b>Male</b>
                        </div>
                        <br/><br/>
                        
                        <?php $phone = isset($status['phoneNumberS'])? $status['phoneNumberS']: "";?>
                        <?php if(isset($status['phoneNumberF'])) echo "<p class = 'failure'>Invalid phone number. Please type in the following format: areacode(02 or 03 or 07 or 08) hyphen phone number(8 digits).</p>";?>
                        <b class = "caption">Phone number</b>
                        <div class = "input_element">
                            <input type = "text" <?php if(strlen($phone)) echo "value = '$phone'"; ?> size = "15" name = "txtPhoneNumber"/>
                        </div>
                        <br/><br/>
                        
                        <?php $mobile = isset($status['mobileNumberS'])? $status['mobileNumberS']: "";?>
                        <?php if(isset($status['mobileNumberF'])) echo "<p class = 'failure'>Invalid mobile number. Please type 10 digits starting from 0.</p>";?>
                        <b class = "caption">Mobile number</b>
                        <div class = "input_element">
                            <input type = "text" <?php if(strlen($mobile)) echo "value = '$mobile'";?> size = "15" name = "txtMobileNumber"/>
                        </div>
                        <br/><br/>
                        
                        <?php $email = isset($status['emailAddressS'])? $status['emailAddressS']: "";?>
                        <?php if(isset($status['emailAddressF'])) echo "<p class = 'failure'>Invalid email address. Please type in the following format: username@subdomain.domain.Subdomain part is optional.Domain part must consist of at least 2 and at most 3 characters.</p>";?>
                        <?php if(isset($status['duplicateEmailAddress'])) echo "<p class = 'failure'>This email address has already been taken.Please use different one.</p>";?>
                        <b class = "caption">Email address</b>
                        <div class = "input_element">
                            <input type = "text" <?php if(strlen($email)) echo "value = '$email'";?> size = "40" name = "txtEmailAddress"/>
                        </div>
                        <br/><br/>
                        
                        <?php $street = isset($status['streetS'])? $status['streetS']: "";?>
                        <?php if(isset($status['streetF'])) echo "<p class = 'failure'>Invalid street name. Please type in the following format: unit/building space streetname. unit and building must be in digit.</p>";?>
                        <b class = "caption">Street</b>
                        <div class = "input_element">
                            <input type = "text" <?php if(strlen($street)) echo "value = '$street'";?> size = "40" name = "txtStreet"/>
                        </div>
                        <br/><br/>
                        
                        <?php $suburb = isset($status['suburbS'])? $status['suburbS']: "";?>
                        <?php if(isset($status['suburbF'])) echo "<p class = 'failure'>Invalid suburb name. Use only alphabets and spaces between words.</p>";?>
                        <b class = "caption">Suburb</b>
                        <div class = "input_element">
                            <input type = "text" <?php if(strlen($suburb)) echo "value = '$suburb'";?> size = "15" name = "txtSuburb"/>
                        </div>
                        <br/><br/>
                        
                        <?php $state = isset($status['stateS'])? $status['stateS']: "";?>
                        <?php if(isset($status['stateF'])) echo "<p class = 'failure'>Invalid selection. Please select a state from the given list.</p>";?>
                        <b class = "caption">State</b>
                        <div class = "input_element">
                            <select id = "state" name = "selState" onchange="updateCity(this.selectedIndex)">
                                <option value = "" style = "color: #999999;">Select your state</option>
                                <?php
                                    foreach($stateList as $thisState)
                                    {
                                        if($state == $thisState)
                                        {
                                            echo "<option value = '$thisState' selected>$thisState</option>";
                                        }
                                        else
                                        {
                                            echo "<option value = '$thisState'>$thisState</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <br/><br/>
                        
                        <?php $city = isset($status['cityS'])? $status['cityS']: "";?>
                        <?php if(isset($status['cityF'])) echo "<p class = 'failure'>Invalid selection. Please select a city from the given list.</p>";?>
                        <b class = "caption">City</b>
                        <div class = "input_element">
                            <select id = "city" name = "selCity">
                                <option value = "" style = "color: #999999;">Select your city</option>
                                <?php if(strlen($city)) echo "<option value = '$city' selected>$city</option>";?>
                            </select>
                        </div>
                        <br/><br/>
                        
                        <?php $postcode = isset($status['postcodeS'])? $status['postcodeS']: "";?>
                        <?php if(isset($status['postcodeF'])) echo "<p class = 'failure'>Invalid postcode. Please type 4 digit postcode number starting from non-zero.</p>";?>
                        <b class = "caption">Postcode</b>
                        <div class = "input_element">
                            <input type = "text" <?php if(strlen($postcode)) echo "value = '$postcode'";?> size = "15" name = "txtPostcode"/>
                        </div>
                        <br/><br/>
                        
                        <?php $password = isset($status['passwordS'])? $status['passwordS']: "";?>
                        <?php if(isset($status['passwordF'])) echo "<p class = 'failure'>Invalid password. Password length must be between 5 to 10 characters. Password and Retype Password fields must match.</p>";?>
                        <b class = "caption">Password</b>
                        <div class = "input_element">
                            <input type = "password" <?php if(strlen($password)) echo "value = '$password'";?> size = "15" name = "txtPassword"/>
                        </div>
                        <br/><br/>
                        
                        <?php $retypePassword = isset($status['retypePasswordS'])? $status['retypePasswordS']: "";?>
                        <b class = "caption">Retype password</b>
                        <div class = "input_element">
                            <input type = "password" <?php if(strlen($retypePassword)) echo "value = '$retypePassword'";?>  size = "15" name = "txtRetypePassword"/>
                        </div>
                        <br/><br/>                   
                        
                        <div class = "input_element">
                            <input type = "submit" name = "btnSubmit" value = "Save"/>&nbsp;&nbsp;
                            <input type = "reset" name = "btnReset" value = "Reset"/>
                        </div>
                        <br/><br/>
                    </div>
                </form>
            </div>
            <?php
                include("../includes/footer_sub.php");
            ?>
        </center>
    </body>
</html>
