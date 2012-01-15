<?php
    require_once('session.php');
    date_default_timezone_set('Australia/Melbourne');
    $title = $heading = "View patient's detail";
    $back = "doctor_view_patient.php";
    
    $req = isset($_GET['req'])? $_GET['req'] : "f";
    if($req == "t")
    {
        $title = $heading = "View requesting patient's detail";
        $back = "doctor_view_patient_request.php";
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system:: <?php echo $title; ?></title>
        <link rel = "stylesheet" type = "text/css" href="../css/style_sub.css" media="screen"></link>
        <script type = "text/javascript" src = "../js/actionConfirmation.js"></script>
    </head>
    <body>
        <center>
            <?php
                include("../includes/header_sub.php");
                require_once('class.person.php');
                $objPerson = new Person();
                $arPatient = $objPerson->getMyDetails($_GET['id']);
            ?>
            <div class = "content">
                <h1>Healthcare support system:: <?php echo $heading; ?></h1>
                                
                <div class = "logout">
                    <p>
                        <a href = "<?php echo $back; ?>">Back</a>&nbsp;|&nbsp;
                        <a href = "../index.php?logout=t">Logout</a>
                    </p>
                </div>
                <?php echo "<p class = 'success'><b>$name</b>'s private page.</p>";?>
                <h2><?php echo $arPatient['firstName'], " ", $arPatient['lastName'], "'s detail<br/>"; ?></h2>
                
                <div class = "message_box" style = "padding:10px;width:759px;">
                    <table>
                    <?php
                        echo "<tr><td class='caption'>Phone</td><td>";
                        echo $arPatient['phoneNumber'], "</td></tr>";
                        
                        echo "<tr><td class='caption'>Mobile</td><td>";
                        echo $arPatient['mobileNumber'], "</td></tr>";
                        
                        echo "<tr><td class='caption'>Email</td><td>";
                        echo $arPatient['emailAddress'], "</td></tr>";
                        
                        echo "<tr style='vertical-align:top;'><td class='caption'>Address</td><td>";
                        echo $arPatient['street'], "<br/>", $arPatient['suburb'], "<br/>", $arPatient['city'], "<br/>", $arPatient['state'], ", ", $arPatient['postcode'],"</td></tr>";
                        
                        echo "<tr><td class='caption'>Sex</td><td>";
                        echo $arPatient['sex'], "</td></tr>";
                        
                        echo "<tr><td class='caption'>DOB</td><td>";
                        echo date_format(new DateTime($arPatient['dob']),"Y-M-d"), "</td></tr>";
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
