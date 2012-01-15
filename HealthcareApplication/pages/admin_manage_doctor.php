<?php require_once('session.php');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system:: Manage doctor</title>
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
                <h1>Healthcare support system::Manage doctor</h1>
                                
                <div class = "logout">
                    <p>
                        <a href = "activities.php">Back</a>&nbsp;|&nbsp;
                        <a href = "../index.php?logout=t">Logout</a>
                    </p>
                </div>
                <?php
                    echo "<p class = 'success'><b>$name</b>'s private page.</p>";
                    
                    if(isset($_GET['del']))
                    {
                        $total = $objPerson->getMyPatients($_GET['id'], true);
                        if($total['totalPerson'] == 0)
                        {
                            if($objPerson->deletePerson($_GET['id']))
                            {
                                echo "<p class='success'>You have successfully deleted the record.</p>";
                            }
                            else
                            {
                                echo "<p class='no_box_failure'>Sorry! record could not be deleted.</p>";
                            }
                        }
                        else
                        {
                            echo "<p class='no_box_failure'>Please de-allocate all patients assigned to this doctor before continuing with the deletion.</p>";   
                        }
                    }
                    $arDoctors = $objPerson->getAllDoctors();
                ?>
                <h2>List of doctors</h2>
                <div class = "message_box" style = "padding:10px;width:759px;">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Patient(s)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                        foreach($arDoctors as $key=>$subArray)
                        {
                            echo "<tr>";
                            echo "<td>",$subArray['firstName']," ",$subArray['lastName'],"</td>";
                            
                            $total = $objPerson->getMyPatients($subArray['personId'], true);
                            
                            echo "<td>{$total['totalPerson']}</td>";
                            if( $total['totalPerson'] == 0)
                            {
                                echo "<td>","<a onclick='return confirmDeletion()' href='",$_SERVER['PHP_SELF'],"?del=t&id={$subArray['personId']}","'>Delete</a>";
                            }
                            else
                            {
                                echo "<td>","<a onclick='return alertMessage()' href='",$_SERVER['PHP_SELF'],"?del=t&id={$subArray['personId']}","'>Delete</a>";  
                            }
                            
                            echo "&nbsp;|&nbsp;";
                            echo "<a href='admin_view_doctor.php?id={$subArray['personId']}'>View detail</a>";
                            echo "</td>";
                            
                            echo "</tr>";
                        }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
                include("../includes/footer_sub.php");
            ?>
        </center>
    </body>
</html>
