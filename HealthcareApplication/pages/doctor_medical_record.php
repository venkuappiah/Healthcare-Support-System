<?php
    date_default_timezone_set('Australia/Melbourne');
    require_once('session.php');
    
    $rid = isset($_GET['rid'])?$_GET['rid']:0;
    $pid = isset($_GET['pid'])?$_GET['pid']:0;
    $pname = isset($_GET['pname'])? $_GET['pname']: "";
    $post = isset($_GET['post'])? $_GET['post']:"";
    $person = array();
    
    if(isset($_POST['txtDoctorName']))
    {
        $name = $_POST['txtDoctorName'];
        $id = $_POST['txtDoctorId'];
        $type = $_POST['txtDoctorType'];
    }
    
    require_once("class.medical_record.php");
    require_once("class.person.php");
    require_once("class.validator.php");   
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system::Doctor's medical record page</title>
        <link rel = "stylesheet" type = "text/css" href="../css/style_sub.css" media="screen"></link>
        <style type = "text/css">
            .record_summary,.record_detail
            {
                position:relative;
                width:290px;
                border-style:dotted;
                border-color:#ff0000;
                border-width:1px;
                left:10px;
            }
            .record_detail
            {
                top:10px;
            }
        </style>
    </head>
    <body>
        <center>
            <?php
                include("../includes/header_sub.php");
                require_once("class.medical_record.php");
            ?>
            
            <div class = "content">
                <h1>Healthcare support system::Patients' medical record</h1>
                <p class="success"><?php echo "<b>$name</b>'s private page."?>
                <?php
                    if($post == "t")
                    {
                        echo "<p class = 'success'>You have successfully sent a message.</p>";
                    }
                    else if($post == "f")
                    {
                        echo "<p class = 'no_box_failure'>Message could not be sent. Please try again.</p>";   
                    }
                    
                ?>
                <div style = "margin:10px;">
                    <?php
                        if(isset($_POST['selPatient']))
                        {
                            $person = explode("+",$_POST['selPatient']);                         
                            if(count($person)==2)
                            {
                                $pid = $person[0];
                                $ar['personId'] =  $person[0];
                                                                
                                Validator::initialize($ar);
                                Validator::checkID();
                                                                
                                $success = $failure = array();
                                $failure = Validator::getFailureArray();
                                $success = Validator::getSuccessArray();
                                
                                if(isset($failure['personIdF']))
                                {
                                    echo "<p class ='failure' style = 'position:relative;left:-10px;width:290px!important;'>Please select a patient before continuing.</p>";
                                }
                                
                                if(isset($success['personIdS']))
                                {
                                    $pid = $success['personIdS'];
                                }
                                
                            }
                        }
                        $objPerson = new Person();
                        $arPatient = $objPerson->getMyPatients($id);
                        
                        if(count($arPatient))
                        {
                            echo "<form name = 'frmViewRecord' method = 'post' action = '",$_SERVER['PHP_SELF'],"'>";
                            echo "<b>Select a patient:&nbsp;&nbsp;&nbsp;&nbsp;</b>";
                            echo "<select name = 'selPatient'>";
                            echo "<option value = '0+ '>Select a patient</option>";
                            
                            for ($i = 0; $i < count($arPatient); ++$i)
                            {
                                $row = $arPatient[$i];
                                if(isset($_POST['selPatient']))
                                {
                                    if($pid == $row['personId'])
                                    {
                                        $pname = $row['firstName']." ".$row['lastName'];
                                        echo "<option selected value = '",$row['personId'],"+",$row['firstName']." ".$row['lastName'],"'>",$row['firstName']." ".$row['lastName'],"</option>";
                                    }
                                    else
                                    {
                                        echo "<option value = '",$row['personId'],"+",$row['firstName']." ".$row['lastName'],"'>",$row['firstName']." ".$row['lastName'],"</option>";
                                    }
                                }
                                else if(isset($_GET['pid']))
                                {
                                    if($pid == $row['personId'])
                                    {
                                        $pname = $row['firstName']." ".$row['lastName'];
                                        echo "<option selected value = '",$row['personId'],"+",$row['firstName']." ".$row['lastName'],"'>",$row['firstName']." ".$row['lastName'],"</option>";
                                    }
                                    else
                                    {
                                        echo "<option value = '",$row['personId'],"+",$row['firstName']." ".$row['lastName'],"'>",$row['firstName']." ".$row['lastName'],"</option>";  
                                    }
                                }
                                else
                                {
                                    echo "<option value = '",$row['personId'],"+",$row['firstName']." ".$row['lastName'],"'>",$row['firstName']." ".$row['lastName'],"</option>";     
                                }
                            }
                            echo "</select>&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<input type = 'submit' name = 'btnSubmit' value = 'View'/>";
                            echo "<input name='txtDoctorName' type = 'hidden' value = '$name'/>";
                            echo "<input name='txtDoctorId' type = 'hidden' value = '$id'/>";
                            echo "<input name='txtDoctorType'type = 'hidden' value = '$type'/>";
                            echo "</form>";
                        }
                        else
                        {
                            echo "<p class ='failure' style = 'position:relative;left:-10px;width:290px!important;'>No patient available.</p>";
                        }
                    ?>
                </div>
                
                <div class = "logout">
                    <p>
                        <a href = "activities.php">Back</a>&nbsp;|&nbsp;
                        <a href = "../index.php?logout=t">Logout</a>
                    </p>
                </div>
                
                <?php
                    if($pid > 0)
                    {
                        echo "<div class = 'record_summary'><p>";
                        $objMedicalRecord = new MedicalRecord($pid);
                        $arMedicalRecord = $objMedicalRecord->getMedicalRecord();
                        
                        if(count($arMedicalRecord))
                        {
                            for($i = 0; $i < count($arMedicalRecord); ++$i)
                            {
                                $row = $arMedicalRecord[$i];
                                if($i == $rid)
                                {
                                    echo date_format(new DateTime($row['datetime']),"Y M d"),"<br/>";
                                }
                                else
                                {                         
                                    echo "<a href ='",$_SERVER['PHP_SELF'],"?pid=$pid&rid=$i&pname=$pname&datetime=",$row['datetime'],"'>",date_format(new DateTime($row['datetime']),"Y M d"),"</a><br/>";
                                }
                            }
                        }
                        else
                        {
                            echo "No medical record available.";
                        }
                        echo "</p></div>";
                        echo "<div class = 'record_detail'>";
                        
                        if(count($arMedicalRecord))
                        {
                            $datetimeRow = isset($arMedicalRecord[$rid])? $arMedicalRecord[$rid]: null;
                            
                            if(is_array($datetimeRow))
                            {
                                $datetime = $datetimeRow['datetime'];
                                
                                $arMedicalRecordDetails = $objMedicalRecord->getMedicalRecordDetails($pid,$datetime);
                                $strDateTime = $strTemperature = $strAskDoctor = "";
                                for($i = 0; $i < count($arMedicalRecordDetails); ++$i)
                                {
                                    $row = $arMedicalRecordDetails[$i];
                                    $strDateTime = $strDateTime.date_format(new DateTime($row['datetime']),"h:i:s A")."<br/>";
                                    $strTemperature = $strTemperature.number_format($row['temperature'],2)."<br/>";
                                    $strAskDoctor = $strAskDoctor."<a href='write-comment.php?pname=$pname&pid=$pid&mid={$row['recordId']}'>Write comment</a><br/>";
                                }
                                echo "<div><h2>Details on ",date_format(new DateTime($datetime),"Y M d"),"</h2></div>";
                                echo "<div><p><b>Time</b><b style = 'position:relative;left:60px;'>Temperature</b><b style = 'position:relative;left:90px;'>Action</b></p></div>";
                                
                                echo "<div>";
                                echo "<p>$strDateTime</p>";
                                echo "<p style ='position:absolute;left:90px;top:58px;'>$strTemperature</p>";
                                echo "<p style = 'position:absolute;left:190px;top:58px;'>$strAskDoctor</p>";
                                echo "</div>";
                            }
                        }
                        else
                        {
                            echo "<div><P>No medical record details available.</p></div>";
                        }
                        echo "</div><br/>";
                    }
                ?>
            </div>
            <?php
                include("../includes/footer_sub.php");
            ?>
        </center>
    </body>
</html>