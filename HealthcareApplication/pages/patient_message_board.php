<?php
    require_once('session.php');
    date_default_timezone_set('Australia/Melbourne');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system::Messageboard page</title>
        <link rel = "stylesheet" type = "text/css" href="../css/style_sub.css" media="screen"></link>
        <script type = "text/javascript" src = "../js/actionConfirmation.js"></script>
    </head>
    <body>
        <center>
            <?php
                include("../includes/header_sub.php");
                require_once('class.discussion.php');
                $objDiscussion = new Discussion();
                
                $delete;
                if(isset($_GET['del']))
                {
                    $delete = $objDiscussion->deleteMessage($_GET['discId']);
                }
                            
                $arMessage = $objDiscussion->getMessage($id);
                $arUnreadMessage = $objDiscussion->getUnreadMessages($id);
                $arMessageSender = $objDiscussion->getMessageSender($id);
            ?>
            <div class = "content">
                <h1>Healthcare support system::Message board</h1>
                                
                <div class = "logout">
                    <p>                        
                        <a href = "activities.php?back">Back</a>&nbsp;|&nbsp;
                        <a href = "../index.php?logout=t">Logout</a>
                    </p>
                </div>
                <?php
                    echo "<p class = 'success'><b>$name</b>'s private page.</p>";
                    
                    if(isset($_GET['del']))
                    {
                        if($delete > 0)
                        {
                            echo "<p class = 'success'>You have successfully deleted the message.</p>";    
                        }
                        else
                        {
                            echo "<p class = 'no_box_failure'>Message could not be deleted. Please try again.</p>";     
                        }
                    }
                ?>
                <h2>Inbox </h2>
                <?php
                    $unread = $str = "";
                    
                    if(count($arUnreadMessage))
                    {
                        $unread = $arUnreadMessage['unread'];
                        $unread = ($arUnreadMessage['unread'] > 0) ? $arUnreadMessage['unread'] : "No";
                        $str = ($unread > 1)? "messages" : "message";
                        
                        echo "<p style = 'position:relative;left:50px;top:-30px;font-weight:bold;'>[ $unread new $str ]</p>";
                    }               
                    
                    if(count($arMessage))
                    {
                        $subjectHeading = "Subject";
                        $senderHeading =  "Sender";
                        $dateHeading = "Received on";
                        $actionHeading = "Action";
                        
                        $subject = $date = $action = $sender = "";
                        echo "<div class= 'message_box'>";
                            echo "<div class = 'message_heading'>";
                                echo "<p class = 'message_subject'>$subjectHeading</p>";
                                echo "<p class = 'message_sender'>$senderHeading</p>";
                                echo "<p class = 'message_date'>$dateHeading</p>";
                                echo "<p class = 'message_action'>$actionHeading</p>";
                            echo "</div>";
                            
                            define("MAX_SUB_CHAR",50);
                            define("MAX_SENDER_CHAR",25);
                            
                            $thisSubject = "";
                            foreach ($arMessage as $row) 
                            {
                                $thisSubject = $row['discussionSubject'];
                                if(strlen($thisSubject) > MAX_SUB_CHAR)
                                {
                                    $thisSubject = substr($thisSubject,0, MAX_SUB_CHAR).".....";
                                }
                                
                                //show unread message in boldface
                                if($row['isViewed'] == 0)
                                {
                                    $thisSubject = "<b>$thisSubject</b>";
                                }
                                $subject = "$subject$thisSubject<br/>";
                                
                                $date = $date.date_format(new DateTime($row['dateTime']),"Y-M-d")."<br/>";
                                                                
                                $action = $action."<a href = 'patient_view_message.php?discId={$row['discussionId']}'>View</a>&nbsp;|&nbsp;";
                                $action = $action."<a onclick = 'return confirmDeletion();' href = '".$_SERVER['PHP_SELF']."?discId={$row['discussionId']}&del"."'>Delete</a><br/>";
                                
                            }
                            
                            $thisSender = "";
                            foreach($arMessageSender as $row)
                            {
                                $thisSender = "{$row['name']} [{$row['emailAddress']}]";
                                if(strlen($thisSender) > MAX_SENDER_CHAR)
                                {
                                    $thisSender = substr($thisSender,0, MAX_SENDER_CHAR).".....";
                                }
                                $sender = "$sender$thisSender<br/>";
                            }
                            echo "<p class = 'message_subject'>$subject</p>";
                            echo "<p class = 'message_sender' style = 'top:25px;'>$sender</p>";
                            echo "<p class = 'message_date' style = 'top:25px;'>$date</p>";
                            echo "<p class = 'message_action' style = 'top:25px;'>$action</p>";
                        echo "</div>";
                    }
                    else
                    {
                        echo "<p class = 'failure' style = 'left:0px; width:200px!important;'>There is no message to display.</p>";
                    }
                ?>
            </div>
            <?php
                include("../includes/footer_sub.php");
            ?>
        </center>
    </body>
</html>
