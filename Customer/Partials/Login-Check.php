<?php
            
            //Authorization - Access Control

//Check whether the user is logged in or not
if (!isset($_SESSION['email'])) //If user session is not set
{
    //User is not logged in
    //Redirect to login page with message
    $_SESSION['not-logged-in'] = "<div style='color: red;'><h3><strong>Please Login To Access Admin Panel!</strong></h3></div>";
    //Redirect to Login Page
    header('location:'.HOMEURL.'customer/Login.php');
}

?>