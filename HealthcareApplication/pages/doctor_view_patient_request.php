<?php require_once('session.php');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system:: View patient's request</title>
        <link rel = "stylesheet" type = "text/css" href="../css/style_sub.css" media="screen"></link>
        <script type = "text/javascript" src = "../js/actionConfirmation.js"></script>
    </head>
    <body>
        <center>
            <?php
                include("../includes/header_sub.php");
                require_once('class.person.php');
                $objPerson = new Person();
                
                $acc = isset($_GET['acc'])? $_GET['acc'] : "";
            ?>
            <div class = "content">
                <h1>Healthcare support system::View Patient's request</h1>
                                
                <div class = "logout">
                    <p>
                        <a href = "activities.php">Back</a>&nbsp;|&nbsp;
                        <a href = "../index.php?logout=t">Logout</a>
                    </p>
                </div>
                <?php
                    echo "<p class = 'success'><b>$name</b>'s private page.</p>";
                    if($acc == "t")
                    {
                        if($objPerson->acceptPatient($_GET['id']) == -1)
                        {
                            echo "<p class = 'no_box_failure'>Accept action failed. Please try again.</p>";
                        }
                        else
                        {
                            echo "<p class = 'success'>You have successfully accepted the patient's request</p>";
                        }

                    }
                    elseif($acc == "f")
                    {
                        if($objPerson->rejectPatient($_GET['id']) == -1)
                        {
                            echo "<p class = 'no_box_failure'>Reject action failed. Please try again.</p>";
                        }
                        else
                        {
                            echo "<p class = 'success'>You have successfully denied the patient's request</p>";
                        }  
                    }
                    $arPatients = $objPerson->getRequestingPatient($_SESSION['sess_info']['id']);
                ?>
                <h2>List of requesting patients</h2>
                
                <?php if(count($arPatients) == 0){?>
                <p class="no_box_failure">No patient request available</p>
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
                            echo "<a href='doctor_view_patient_details.php?req=t&id={$subArray['personId']}'>View detail</a>";
                            echo "&nbsp;|&nbsp;";
                            
                            echo "<a href='doctor_view_patient_request.php?acc=t&id={$subArray['personId']}'>Accept</a>";
                            echo "&nbsp;|&nbsp;";
                            
                            echo "<a href='doctor_view_patient_request.php?acc=f&id={$subArray['personId']}'>Reject</a>";
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
