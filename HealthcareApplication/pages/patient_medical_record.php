<?php
    date_default_timezone_set('Australia/Melbourne');
    require_once('session.php');
        
    $rid = isset($_GET['rid'])?$_GET['rid']:0;
    $post = isset($_GET['post'])? $_GET['post']:"";
    
    require_once("class.medical_record.php");
    $objMedicalRecord = new MedicalRecord($id);
    $arMedicalRecord = $objMedicalRecord->getMedicalRecord();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system::Patient's medical record page</title>
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
                top:10px;*/
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
                <div>
                    <h1>Healthcare support system::Patient's medical record</h1>
                    <?php
                        if(isset($name))
                        {
                            echo "<p class = 'success'><b>$name's</b> private page.</p>";
                        }
                        if($post =="t")
                        {
                            echo "<p class = 'success'>You have successfully sent a message.</p>";  
                        }
                        if($post =="f")
                        {
                            echo "<p class = 'no_box_failure'>Message could not be sent.Please try again.</p>";     
                        }
                    ?>
                </div>
                
                <div class = "logout">
                    <p>
                        <a href = "activities.php?back">Back</a>&nbsp;|&nbsp;
                        <a href = "../index.php?logout=t">Logout</a>
                    </p>
                </div>
                
                <div class = "record_summary">
                    <p>
                    <?php
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
                                    echo "<a href ='",$_SERVER['PHP_SELF'],"?rid=$i&datetime=",$row['datetime'],"'>",date_format(new DateTime($row['datetime']),"Y M d"),"</a><br/>";                          
                                }
                            }
                        }
                        else
                        {
                            echo "No medical record available.";
                        }
                    ?>
                    </p>
                </div>
                <div class = "record_detail">
                    <?php
                        if(count($arMedicalRecord))
                        {
                            $datetimeRow = isset($arMedicalRecord[$rid])? $arMedicalRecord[$rid]: null;
                            
                            if(is_array($datetimeRow))
                            {
                                $datetime = $datetimeRow['datetime'];
                                $arMedicalRecordDetails = $objMedicalRecord->getMedicalRecordDetails($id,$datetime);
                                $strDateTime = $strTemperature = $strAskDoctor = "";
                                for($i = 0; $i < count($arMedicalRecordDetails); ++$i)
                                {
                                    $row = $arMedicalRecordDetails[$i]; 
                                    $strDateTime = $strDateTime.date_format(new DateTime($row['datetime']),"h:i:s A")."<br/>";
                                    $strTemperature = $strTemperature.number_format($row['temperature'],2)."<br/>";
                                    $strAskDoctor = $strAskDoctor."<a href='ask-doctor.php?mid={$row['recordId']}'>Ask doctor</a><br/>";
                                }
                                echo "<div><h1>Details on ",date_format(new DateTime($datetime),"Y M d"),"</h1></div>";
                                echo "<div><p><b>Time</b><b style = 'position:relative;left:60px;'>Temperature</b><b style = 'position:relative;left:100px;'>Action</b></p></div>";
                                
                                echo "<div>";
                                echo "<p>$strDateTime</p>";
                                echo "<p style ='position:absolute;left:90px;top:65px;'>$strTemperature</p>";
                                echo "<p style = 'position:absolute;left:200px;top:65px;'>$strAskDoctor</p>";
                                echo "</div>";
                            }
                        }
                        else
                        {
                            echo "<div><P>No medical record details available.</p></div>";
                        }
                    ?>
                </div>
                <br/>
            </div>
            <?php
                include("../includes/footer_sub.php");
            ?>
        </center>
    </body>
</html>