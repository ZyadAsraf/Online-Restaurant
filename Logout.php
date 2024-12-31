<?php
//Include Constants Page
include('Config/Constant.php');

//Destory the Session
session_destroy();

//Redirect to Login Page
header('location:'.HOMEURL.'Login.php');

?>