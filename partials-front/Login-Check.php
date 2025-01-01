<?php
            
            //Authorization - Access Control

//Check whether the user is logged in or not
if (isset($_SESSION['email'])) //If user session is not set
{   
    if ($_SESSION['role'] != "customer") //If user is logged in and is an admin
    {
    $_SESSION['not-logged-in'] = "<div style='color: red;'><h3><strong>Please Sign out of ".$_SESSION['role']." account first!</strong></h3></div>";
    header('location:'.HOMEURL.'Login.php');
    }
}
else {
    //User is not logged in
    //Redirect to login page with message
    $_SESSION['not-logged-in'] = "<div style='color: red;'><h3><strong>Please Login To Access make orders!</strong></h3></div>";
    //Redirect to Login Page
    header('location:'.HOMEURL.'Login.php');
}
?>