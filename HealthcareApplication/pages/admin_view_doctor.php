<?php require_once('session.php');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system:: View doctor's detail</title>
        <link rel = "stylesheet" type = "text/css" href="../css/style_sub.css" media="screen"></link>
        <script type = "text/javascript" src = "../js/actionConfirmation.js"></script>
    </head>
    <body>
        <center>
            <?php
                date_default_timezone_set('Australia/Melbourne');
                include("../includes/header_sub.php");
                require_once('class.person.php');
                $objPerson = new Person();
                $arDoctor = $objPerson->getMyDetails($_GET['id']);
                $arPatients = $objPerson->getMyPatients($_GET['id']);
            ?>
            <div class = "content">
                <h1>Healthcare support system:: View doctor's details</h1>
                                
                <div class = "logout">
                    <p>
                        <a href = "admin_manage_doctor.php">Back</a>&nbsp;|&nbsp;
                        <a href = "../index.php?logout=t">Logout</a>
                    </p>
                </div>
                <?php echo "<p class = 'success'><b>$name</b>'s private page.</p>";?>
                <h2>Dr <?php echo $arDoctor['firstName'], " ", $arDoctor['lastName'], "'s detail<br/>"; ?></h2>
                <div class = "message_box" style = "padding:10px;width:759px;">
                    <table>
                    <?php
                        echo "<tr><td class='caption'>Phone</td><td>";
                        echo $arDoctor['phoneNumber'], "</td></tr>";
                        
                        echo "<tr><td class='caption'>Mobile</td><td>";
                        echo $arDoctor['mobileNumber'], "</td></tr>";
                        
                        echo "<tr><td class='caption'>Email</td><td>";
                        echo $arDoctor['emailAddress'], "</td></tr>";
                        
                        echo "<tr style='vertical-align:top;'><td class='caption'>Address</td><td>";
                        echo $arDoctor['street'], "<br/>", $arDoctor['suburb'], "<br/>", $arDoctor['city'], "<br/>", $arDoctor['state'], ", ", $arDoctor['postcode'],"</td></tr>";
                        
                        echo "<tr><td class='caption'>Sex</td><td>";
                        echo $arDoctor['sex'], "</td></tr>";
                        
                        echo "<tr><td class='caption'>DOB</td><td>";
                        echo date_format(new DateTime($arDoctor['dob']),"Y-M-d"), "</td></tr>";
                        
                        echo "<tr><td class='caption'>Patient(s)</td><td>";
                        foreach ($arPatients as $key=>$subArray)
                        {
                            echo $subArray['firstName'], " ", $subArray['lastName'], "<br/>";  
                        }
                    ?>
                    </table>
                </div>
            </div>
            <?php
                include("../includes/footer_sub.php");
            ?>
        </center>
    </body>
</html>
