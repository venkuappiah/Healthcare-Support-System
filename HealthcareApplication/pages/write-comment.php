<?php
    require_once('session.php');
    require_once('discussion.php');
    require_once('class.validator.php');
    
    $pid = isset($_GET['pid'])? $_GET['pid']: "";
    $pname = isset($_GET['pname'])? $_GET['pname']: "";
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
        $pid = $_POST['idHidden'];
        $pname = $_POST['nameHidden'];
        $mid = $_POST['recordIdHidden'];
    }
    
    if(isset($_POST['dIdHidden']))
    {
        $id = $_POST['dIdHidden'];
        $type = $_POST['dTypeHidden'];
        $name = $_POST['dNameHidden'];
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system::Write comment</title>
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
                    <h1>Healthcare support system::Write comment</h1>
                    <?php echo "<p class = 'success'><b>$name</b>'s private page.</p>";?>
                </div>
                
                <div class = "logout">
                    <p>
                        <a href = "doctor_medical_record.php?<?php echo "pname=$pname&pid=$pid";?>">Back</a>&nbsp;|&nbsp;
                        <a href = "../index.php?logout=t">Logout</a>
                    </p>
                </div>
                
                <div class = "message_form">
                    <form name='frmWriteComment' method='POST' action = '<?php echo $_SERVER['PHP_SELF'];?>'>
                        <span class="caption">Send to:</span>
                        <select class = "input" name="selPatient">
                            <option value="<?php echo $pid."+".$pname;?>"><?php echo $pname;?></option>
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
                        
                        <input type = "hidden" name = "idHidden" value="<?php echo $pid;?>"/>
                        <input type = "hidden" name = "recordIdHidden" value="<?php echo $mid;?>"/>
                        <input type = "hidden" name = "nameHidden" value="<?php echo $pname;?>"/>
                        
                        <input type = "hidden" name = "dIdHidden" value="<?php echo $id;?>"/>
                        <input type = "hidden" name = "dNameHidden" value="<?php echo $name;?>"/>
                        <input type = "hidden" name = "dTypeHidden" value="<?php echo $type;?>"/>
                    </form>
                </div>
            </div>
            </div>
            <?php include("../includes/footer_sub.php"); ?>
        </center>
    </body>
</html>