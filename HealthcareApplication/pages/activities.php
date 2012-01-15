<?php require_once('session.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system::Activities page</title>
        <link rel = "stylesheet" type = "text/css" href="../css/style_sub.css" media="screen"></link>
    </head>
    <body>
        <center>
            <?php include("../includes/header_sub.php"); ?>
            <div class = "content">
                <h1>Healthcare support system::Activities</h1>
                <?php
                    $registration = isset($_GET['reg'])? $_GET['reg'] : "";
                    $user = "";
                    
                    if($type =="p")
                    {
                        $user = "a patient";
                    }
                    else if($type =="d")
                    {
                        $user = "a doctor";
                    }elseif($type =="a")
                    {
                        $user = "an administrator";
                    }
                    
                    if(isset($_GET['back']))
                    {
                        echo "<p class = 'success'><b>$name</b>'s private page.</p>"; 
                    }
                    elseif($registration =='t')
                    {
                        echo "<p class = 'success'>You have successfully added a doctor.</p>";
                    }
                    elseif($registration == 'f')
                    {
                        echo "<p class = 'failure'>Sorry! Account could not be created for this doctor. Please try again.</p>";
                    }
                    else
                    {
                        echo "<p class = 'success'>Welcome <b>$name</b>. You are logged in as $user.</p>";  
                    }
                ?>
                <div class = "logout" style = "top:10px;left:750px;">
                    <a href = "../index.php?logout=t">Logout</a>
                </div>
                
                <div class= "activity_box">
                    <!--<a href = "#">Reset password</a><br/>-->
                    <?php
                        if ($type == "d")
                        {
                            echo "<a href = 'doctor_medical_record.php'>View patients' medical record</a>","<br/>";
                            echo "<a href = 'doctor_message_board.php'>Go to messageboard</a>", "<br/>";
                            echo "<a href = 'doctor_view_patient.php'>View current patients</a>", "<br/>";
                            echo "<a href = 'doctor_view_patient_request.php'>View patients request</a>";
                        }
                        else if ($type == "p")
                        {
                            echo "<a href = 'patient_medical_record.php'>View medical record</a>","<br/>";
                            echo "<a href = 'patient_message_board.php'>Go to messageboard</a>";
                        }
                        else if($type =="a")
                        {
                            echo "<a href = 'doctor_registration_form.php'>Add new doctor</a>","<br/>";
                            echo "<a href = 'admin_manage_doctor.php'>Manage doctors</a>";   
                        }
                    ?>
                    <br/>
                    <!--<a href = "#">Update personal details</a><br/>-->
                </div>
            </div>
            <?php
                include("../includes/footer_sub.php");
            ?>
        </center>
    </body>
</html>
