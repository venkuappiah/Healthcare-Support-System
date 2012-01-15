<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system::Homepage</title>
        <link rel = "stylesheet" type = "text/css" href="css/style_home.css" media="screen"></link>
    </head>
    <body>
        <center>
            <?php
                require_once("pages/login.php");
                require_once("includes/header_home.php");
            ?>
            <div class = "content">
                <h1>Healthcare support system::About Us</h1>
                <p>
                    In remote Australia there are limited healthcare facilities. People living there need to go to urban centers
                    by travelling long distances for their treatment. Quite often these people are less likely to
                    get immediate healthcare services. There seems to have at least two fundamental causes behind this. The first one is that they
                    live far from city centers where healthcare facilities are sufficiently available. Next, they live in
                    isolation which means when they get critically ill, it is likely that there will not be anybody to take care of them and to pass the
                    information to the outside world.                    
                </p> 
                
                <p>
                    This could be very dangerous to patients' health. If there condition goes lately noticed or even unnoticed, for them
                    it could mean anything from worsening of health to the loss of life. One solution to this problem lies in automating
                    the delivery of information comprising patients' identity and their health-related data to the relevant institutions in real-time.
                </p>
                <p>
                    The Healthcare Support System(HSS) project is being undertaken to solve this issue. With this solution, a patient should have
                    a sensor attached to her body. The sensor constantly sends her health-intrinsic data to PDA or any compatible mobile
                    device. For the security reason, the patient must authenticate herself by providing credentials to the central
                    database. Once the patient is authenticated, PDA can monitor her health-intrinsic data and can update the central database whenever
                    the data goes beyond the normal range. It all happens automatically. 
                </p>
                <p>
                    Doctors can then access patients' updated health-intrinsic data from anywhere by using Healthcare Support System website.
                    Patients and doctors can also discuss about health-related issues using the website. In this way, patients and doctors become
                    well connected to each other.
                </p>
                <p>
                    The scope of the project can be further widened by implementing an automated SMS service as an effective way to inform the doctor
                    whenever patients' condition becomes critical. Yet another option is to implement an automatic dialing to the nearest ambulance
                    service.
                </p>
                <div class = "login_form">
                    <h2>Login</h2>
                    <?php
                        $logout = isset($_GET['logout'])? $_GET['logout']: "";
                        $registration = isset($_GET['reg'])? $_GET['reg']: "";
                        
                        if(isset($isLoggedIn))
                        {
                            if(!isset($_SESSION['auth']))
                            {
                                echo "<p class = 'failure'>Login failed. Please try again.</p>";
                            }                           
                        }
                        
                        if($logout == 't')
                        {
                            if(isset($_SESSION))
                            {
                                $_SESSION = array();
                                session_destroy();
                            }
                            echo "<p class = 'success'>You have successfully logged out.</p>";
                        }
                        
                        if($registration =='t')
                        {
                            echo "<p class = 'success'>You have successfully created an account.</p>";
                        }
                        elseif($registration == 'f')
                        {
                            echo "<p class = 'failure'>Sorry! account could not be created. Please try again.</p>";
                        }
                        
                        if(isset($_SESSION['auth']))
                        {
                            if($_SESSION['auth'] == false)
                            {
                                echo "<p class = 'failure'>Access denied. You must login to access the private page.</p>";
                                $_SESSION = array();
                                session_destroy();
                            }
                        }
                    ?>
                    <form name = "frmLogin" method = "post" action = "<?php echo $_SERVER['PHP_SELF'];?>">
                        <input type="hidden" name="inputLoginHidden"/>
                        <b>Username</b>
                        <input class = "input" type = "text" name = "txtUsername" size = "20"/> <br/><br/>
                        <b>Password</b>
                        <input class ="input" type = "password" name = "txtPassword" size = "20"/> <br/><br/>
                        <div class= "login_button">
                            <input type = "submit" name = "btnSubmit" value="submit"/>&nbsp;&nbsp;
                            <input type= "reset" name = "btnReset" value = "reset"/>
                        </div>
                    </form>
                    
                    <!--<a href="admin_login.php">Login as an administrator</a>-->
                    
                    <!--<h2>Register</h2>-->
                    <a href="pages/registration_form.php">Create a new account</a>
                </div>
            </div>
            <?php include("includes/footer_home.php"); ?>
        </center>
    </body>
</html>
