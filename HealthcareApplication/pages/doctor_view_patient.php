<?php require_once('session.php');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system:: View patient</title>
        <link rel = "stylesheet" type = "text/css" href="../css/style_sub.css" media="screen"></link>
        <script type = "text/javascript" src = "../js/actionConfirmation.js"></script>
    </head>
    <body>
        <center>
            <?php
                include("../includes/header_sub.php");
                require_once('class.person.php');
                $objPerson = new Person();
            ?>
            <div class = "content">
                <h1>Healthcare support system::View Patient</h1>
                                
                <div class = "logout">
                    <p>
                        <a href = "activities.php">Back</a>&nbsp;|&nbsp;
                        <a href = "../index.php?logout=t">Logout</a>
                    </p>
                </div>
                <?php
                    echo "<p class = 'success'><b>$name</b>'s private page.</p>";
                    $arPatients = $objPerson->getMyPatients($_SESSION['sess_info']['id']);
                ?>
                <h2>List of patients</h2>
                
                <?php if(count($arPatients) == 0){?>
                <p class="no_box_failure">No patient available</p>
                <?php }else{?>
                
                <div class = "message_box" style = "padding:10px;width:759px;">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                        foreach($arPatients as $key=>$subArray)
                        {
                            echo "<tr>";
                            echo "<td>", $subArray['firstName'], " ", $subArray['lastName'], "</td>";
                            
                            echo "<td>"; 
                            echo "<a href='doctor_view_patient_details.php?id={$subArray['personId']}'>View detail</a>";
                            echo "</td>";
                            
                            echo "</tr>";
                        }
                    ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            </div>
            <?php
                include("../includes/footer_sub.php");
            ?>
        </center>
    </body>
</html>
