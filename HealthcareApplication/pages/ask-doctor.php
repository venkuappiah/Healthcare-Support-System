<?php
    require_once('session.php');
    require_once('discussion.php');
    require_once('class.person.php');
    require_once('class.validator.php');
    
    $mid = isset($_GET['mid'])? $_GET['mid']: "";
    
    
    $sub = "";
    if(isset($_POST['txtSubject']))
    {
        $sub = trim($_POST['txtSubject']);
    }
    
    $msg = "";
    if(isset($_POST['txtMessage']))
    {
        $msg = trim($_POST['txtMessage']);
    }
    
    if(isset($_POST['idHidden']))
    {
        $id = $_POST['idHidden'];
        $name = $_POST['nameHidden'];
        $type = $_POST['typeHidden'];
        $mid = $_POST['recordIdHidden'];
    }
    
    $objPerson = new Person();
    $arDoctor = $objPerson->getMyDoctor($id);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system::Ask doctor</title>
        <link rel = "stylesheet" type = "text/css" href="../css/style_sub.css" media="screen"></link>
        <style type="text/css">
            .caption
            {
                position:absolute;
                font-weight:bold;
                width:75px;
                display:block;
            }
            
            .input,.button
            {
                position:relative;
                left:75px;
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
                    <h1>Healthcare support system::Ask doctor</h1>
                    <?php echo "<p class = 'success'><b>$name's</b> private page.</p>";?>
                </div>
                
                <div class = "logout">
                    <p>
                        <a href = "patient_medical_record.php">Back</a>&nbsp;|&nbsp;
                        <a href = "../index.php?logout=t">Logout</a>
                    </p>
                </div>
            <?php
                if(count($arDoctor))
                {
                            
            ?>
                <div class = "message_form">
                    <form name='frmAskDoctor' method='POST' action = '<?php echo $_SERVER['PHP_SELF'];?>'>
                        <span class="caption">Send to:</span>
                        <select class = "input" name="selDoctor">
                            <?php
                                echo "<option value = '",$arDoctor['personId'],"+",$arDoctor['firstName']." ".$arDoctor['lastName'],"'>",$arDoctor['firstName']." ".$arDoctor['lastName'],"</option>";
                            ?>
                        </select><br/><br/>
                    <?php    
                        if(isset($status['discussionSubjectF']))
                        {
                            echo "<p class ='failure' style = 'position:relative;left:65px;width:405px!important;'>Please provide a subject for the message.</p>";
                        }
                    ?>
                        <span class = "caption">Subject:</span>
                        <input class = "input" type="text" size="65" name="txtSubject" value="<?php echo $sub;?>"/><br/><br/>
                        
                    <?php    
                        if(isset($status['discussionContentF']))
                        {
                            echo "<p class ='failure' style = 'position:relative;left:65px;width:405px!important;'>Please provide a message.</p>";
                        }
                    ?>
                        <span class="caption">Message:</span>
                        <textarea class = "input" name="txtMessage" rows="10" cols="50"><?php echo $msg;?></textarea><br/><br/>
                        
                        <div class = "button">
                            <input type="submit" name="txtSubmit" value="Send"/>
                            <input type="reset" name="txtReset" value="Reset"/>
                        </div>
                        <input type = "hidden" name = "idHidden" value="<?php echo $id;?>"/>
                        <input type = "hidden" name = "nameHidden" value="<?php echo $name;?>"/>
                        <input type = "hidden" name = "typeHidden" value="<?php echo $type;?>"/>
                        <input type = "hidden" name = "recordIdHidden" value="<?php echo $mid;?>"/>
                    </form>
                </div>
            </div>
            <?php
                }
                else
                {
            ?>
                <p class="failure" style = "left:0px; width:200px!important;">No doctor available</p>
            </div>
            <?php
                }
                include("../includes/footer_sub.php");
            ?>
        </center>
    </body>
</html>