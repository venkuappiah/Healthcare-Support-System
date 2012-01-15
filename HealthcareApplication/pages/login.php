<?php
    session_start();
    $isLoggedIn;
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        require_once("class.login.php");
        
        $username = $password = "";
        if(isset($_POST['inputLoginHidden'])){
            $username = $_POST['txtUsername'];
            $password = $_POST['txtPassword'];
            
        }elseif(isset($_POST['inputAdminLoginHidden'])){
            $username = $_POST['txtUsernameAdmin'];
            $password = $_POST['txtPasswordAdmin'];
        }
        
        $login = new Login();
        $row = $login->doLogin($username, $password);
        
        if(is_array($row))
        {
            $id = $row['personId'];
            $type = $row['personType'];
            $name = $row['firstName']." ".$row['lastName'];
            
            $_SESSION['sess_info'] = array('sess_id'=>session_id(), 'name'=>$name,'id'=>$id,'type'=>$type);
            
            header("Location:pages/activities.php");
        }
        else
        {
            $isLoggedIn = false;
        }
    }
?>