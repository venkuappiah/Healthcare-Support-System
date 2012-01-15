<?php
    session_start();
    
    $name = $id = $type = $user = "";
    $auth = false;
    
    if(isset($_SESSION['sess_info']))
    {
        if($_SESSION['sess_info']['sess_id'] == session_id())
        {
            $name = $_SESSION['sess_info']['name'];
            $id = $_SESSION['sess_info']['id'];
            $type = $_SESSION['sess_info']['type'];
            $auth = true;
        }        
    }
    
    if($auth == false)
    {
        $_SESSION['auth'] = false;
        header("location: ../index.php");
    }
?>