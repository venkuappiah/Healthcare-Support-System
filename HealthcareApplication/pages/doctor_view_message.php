<?php
    require_once("session.php");
    date_default_timezone_set('Australia/Melbourne');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <title>Healthcare support system::View message page</title>
        <link rel = "stylesheet" type = "text/css" href="../css/style_sub.css" media="screen"></link>
        <script type = "text/javascript" src = "../js/actionConfirmation.js"></script>
    </head>
    <body>
        <center>
            <?php
                include("../includes/header_sub.php");
                require_once('class.discussion.php');
                require_once('class.person.php');
                
                $objPerson = new Person();
                $objDiscussion = new Discussion();
                $discId = isset($_GET['discId']) ? $_GET['discId'] : 0;
                
                $arMyDetails = $objPerson->getMyDetails($id);
                $arMessageSender = $objDiscussion->getMessageSender($discId,true);
            ?>
            <div class = "content">
                <h1>Healthcare support system::View message</h1>
                                
                <div class = "logout">
                    <p>
                        <a href = "doctor_message_board.php">Back</a>&nbsp;|&nbsp;
                        <a href = "../index.php?logout=t">Logout</a>
                    </p>
                </div>
                <?php echo "<p class = 'success'><b>$name</b>'s private page.</p>"; ?>
                <h2>Message detail</h2>
                <div class = "message_box" style = "padding:10px;width:760px;">
                    <div>
                        <b class = "caption">To</b>
                        <p class = "message_detail">
                            <?php echo "{$arMyDetails['firstName']} {$arMyDetails['lastName']} [ {$arMyDetails['emailAddress']} ]"; ?>
                        </p>
                    </div>
                    
                    <div>
                        <b class = "caption">From</b>
                        <p class = "message_detail">
                            <?php echo "{$arMessageSender['name']} [ {$arMessageSender['emailAddress']} ]"; ?>
                        </p>
                    </div>
                    
                    <div>
                        <b class = "caption">Date</b>
                        <p class = "message_detail">
                            <?php echo date_format(new DateTime($arMessageSender['datetime']),"Y-M-d"); ?>
                        </p>
                    </div>
                    
                    <div>
                        <b class = "caption">Time</b>
                        <p class = "message_detail">
                            <?php echo date_format(new DateTime($arMessageSender['datetime']),"g:i:s A"); ?>
                        </p>
                    </div>
                    
                    <div>
                        <b class = "caption">Subject</b>
                        <p class = "message_detail">
                            <?php echo $arMessageSender['discussionSubject']; ?>
                        </p>
                    </div>
                    
                    <div>
                        <b class = "caption">Message</b>
                        <p class = "message_detail">
                            <?php echo str_replace("\n","<br/>",$arMessageSender['discussionContent']); ?>
                        </p>
                    </div>
                    <p class = "message_detail">
                        <a onclick = "return confirmDeletion()" href = "doctor_message_board.php?<?php echo "discId=$discId&del";?>">Delete</a>&nbsp;&nbsp;|
                        <a href = "doctor_message_board.php">Inbox</a>
                    </p>
                </div>
            </div>
            <?php
                $objDiscussion->setViewStatus(1,$discId);
                include("../includes/footer_sub.php");
            ?>
        </center>
    </body>
</html>
