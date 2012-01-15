<?php
require_once('class.web_service.php');

$objWebService = new WebService();
echo $objWebService->authenticateUser("rubella@gmail.com", "rubella");
//echo $str;
?>